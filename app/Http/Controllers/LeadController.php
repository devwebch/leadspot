<?php
/**
 * Created by PhpStorm.
 * User: SIMON
 * Date: 08.08.2016
 * Time: 16:45
 */

namespace App\Http\Controllers;

use App\Contact;
use App\Lead;
use App\User;
use App\Library\DetectCMS\DetectCMS;
use Dompdf\Options;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use League\Flysystem\Config;
use Dompdf\Dompdf;

class LeadController extends Controller
{

    public function __construct()
    {
        // require authentication for the whole Controller
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function searchLead(Request $request)
    {
        // get the authenticated user
        $user        = $request->user();
        $parent      = $user->parent();

        $lead_author = $user->id;
        if ( $parent ) { $lead_author = $parent->id; }

        // get the tour param
        $tour = $request->input('tour');

        // get user leads
        $leads = Lead::where('user_id', $lead_author)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // retrieve lead status
        $status = config('constants.lead.status');

        $status_classes = config('constants.lead.classes');

        // get search categories
        $categories = trans('search.categories');
        asort($categories);

        return view('leads.search', [
            'tour'              => $tour,
            'categories'        => $categories,
            'leads'             => $leads,
            'status'            => $status,
            'status_classes'    => $status_classes,
        ]);
    }

    /**
     * Retrieve a single lead
     * @param Lead $lead
     * @param Request $request
     * @return View
     */
    public function viewLead(Lead $lead, Request $request)
    {
        $user   = $request->user();
        $parent = $user->parent();

        // if the account is a child account, the target account is the parent
        if ( $parent ) {
            $user = User::find($parent->id);
        }

        if ( $lead->user_id != $user->id ) { return redirect('/'); }

        // retrieve lead status
        $status = config('constants.lead.status');

        $leadService = new LeadServiceController();

        $status_classes = config('constants.lead.classes');

        $stored_contacts    = Contact::where('lead_id', $lead->id)->count();
        $available_contacts = $stored_contacts;

        if ( $stored_contacts == 0 ) {
            $available_contacts = $leadService->checkLeadEmails($lead);
        }

        // retrieve lead report
        $report         = $lead->reports()->first();
        // get report's data
        $scores         = !empty($report->scores) ? json_decode($report->scores) : '';
        $stats          = !empty($report->stats) ? json_decode($report->stats) : '';
        $indicators     = !empty($report->indicators) ? json_decode($report->indicators) : '';
        $website        = !empty($report->website) ? json_decode($report->website) : '';

        $indicators_labels = [
            'viewport'          => trans('report.indicators.viewport'),
            'gzip'              => trans('report.indicators.gzip'),
            'minifyCss'         => trans('report.indicators.minifyCss'),
            'minifyJs'          => trans('report.indicators.minifyJs'),
            'minifyHTML'        => trans('report.indicators.minifyHTML'),
            'optimizeImages'    => trans('report.indicators.optimizeImages'),
            'fontSize'          => trans('report.indicators.fontSize'),
        ];

        return view('leads.view', [
            'lead'                  => $lead,
            'status'                => $status,
            'status_classes'        => $status_classes,
            'stored_contacts'       => $stored_contacts,
            'available_contacts'    => $available_contacts,
            'scores'                => $scores,
            'stats'                 => $stats,
            'indicators'            => $indicators,
            'indicators_labels'     => $indicators_labels,
        ]);
    }

    /**
     * Retrieve leads associated with logged in user
     * @param Request $request
     * @return View
     */
    public function getLeads(Request $request)
    {
        // get the authenticated user
        $user   = $request->user();
        $parent = $user->parent();

        // if the account is a child account, the target account is the parent
        if ( $parent ) {
            $user = User::find($parent->id);
        }

        // retrieve lead status
        $status = config('constants.lead.status');

        $status_classes = config('constants.lead.classes');

        // retrieve all entries
        $leads  = Lead::where('user_id', $user->id)
                    ->orderBy('name', 'asc')
                    ->get();

        return view('leads.list', [
            'leads'             => $leads,
            'status'            => $status,
            'status_classes'    => $status_classes,
        ]);
    }

    /**
     * Add lead view
     * @param Request $request
     * @return View
     */
    public function newLead(Request $request)
    {
        $lead = new Lead();

        // retrieve lead status
        $status = config('constants.lead.status');

        $status_classes = config('constants.lead.classes');

        return view('leads.form', [
            'lead'              => $lead,
            'status'            => $status,
            'status_classes'    => $status_classes,
        ]);
    }

    /**
     * Edit lead view
     * @param Lead $lead
     * @param Request $request
     * @return View
     */
    public function editLead(Lead $lead, Request $request)
    {
        // get the authenticated user
        $user   = $request->user();
        $parent = $user->parent();

        // if the account is a child account, the target account is the parent
        if ( $parent ) {
            $user = User::find($parent->id);
        }

        // retrieve lead status
        $status = config('constants.lead.status');

        $status_classes = config('constants.lead.classes');

        // if the user ID of the lead matches the logged in user
        if ( $user->id == $lead->user_id ) {
            $request->request->add(['leadID' => $lead->id]);
            return view('leads.form', [
                'lead'          => $lead,
                'submit_label'  => 'Save',
                'status'        => $status,
                'status_classes'    => $status_classes,
            ]);
        } else {
            return view('shared.error_page');
        }
    }

    /**
     * Store lead in db
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeLead(Request $request)
    {
        // get the authenticated user
        $user   = $request->user();
        $parent = $user->parent();
        $mode   = 'add';

        // if the account is a child account, the target account is the parent
        if ( $parent ) {
            $user = User::find($parent->id);
        }

        // set validation rules
        $this->validate($request, [
            'leadName'      => 'required',
            'leadAddress'   => 'required',
        ]);

        // if it is an update, we retrieve the Lead object
        if ($request->_id) {
            $lead = Lead::find($request->_id);
            $mode = 'edit';
        } else {
            $lead   = new Lead;
        }

        // set the model value
        $lead->name         = $request->leadName;
        $lead->address      = $request->leadAddress;
        $lead->url          = $request->leadUrl;
        $lead->lat          = $request->leadLat;
        $lead->lng          = $request->leadLng;
        $lead->notes        = $request->leadNotes;
        $lead->status       = $request->leadStatus;
        $lead->user_id      = $user->id;

        // insert the model in DB
        $lead->save();

        if ( $mode == 'edit' ) {
            return redirect('leads/view/' . $lead->id);
        }

        // redirect to Leads list
        return redirect('/leads/list');
    }

    /**
     * Delete lead
     * @param Lead $lead
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function deleteLead(Lead $lead, Request $request)
    {
        // get the authenticated user
        $user   = $request->user();
        $parent = $user->parent();

        // if the account is a child account, the target account is the parent
        if ( $parent ) {
            $user = User::find($parent->id);
        }

        // check if the lead author is the authenticated user
        if ( $user->id == $lead->user_id ) {
            $lead->delete();
            $lead->reports()->delete();
            return redirect('leads/list');
        } else {
            return view('shared.error_page');
        }
    }

    public function report(Lead $lead)
    {
        $user = Auth::user();
        $parent = $user->parent();

        // if the account is a child account, the target account is the parent
        if ( $parent ) {
            $user = User::find($parent->id);
        }

        if ( $lead->user_id != $user->id ) { return; }

        // get the first report
        $report     = $lead->reports()->first();

        if ( !$report ) {
            return;
        }

        // get report's data
        $scores         = !empty($report->scores) ? json_decode($report->scores) : '';
        $stats          = !empty($report->stats) ? json_decode($report->stats) : '';
        $indicators     = !empty($report->indicators) ? json_decode($report->indicators) : '';
        $website        = !empty($report->website) ? json_decode($report->website) : '';

        $indicators_labels = [
            'viewport'          => trans('report.indicators.viewport'),
            'gzip'              => trans('report.indicators.gzip'),
            'minifyCss'         => trans('report.indicators.minifyCss'),
            'minifyJs'          => trans('report.indicators.minifyJs'),
            'minifyHTML'        => trans('report.indicators.minifyHTML'),
            'optimizeImages'    => trans('report.indicators.optimizeImages'),
            'fontSize'          => trans('report.indicators.fontSize'),
        ];

        /*$path ='https://maps.googleapis.com/maps/api/staticmap?center='.$lead->lat.','.$lead->lng.'&markers=color:red%7C'.$lead->lat.','.$lead->lng.'&size=330x200&zoom=15&format=jpg&key=AIzaSyAmuoso1k61TZCOqUdPi3E7VIl2HA2UBmA';
        $file = file_get_contents($path);

        Storage::disk('public')->put('test.jpg', $file, 'public');*/

        // store view
        $view           = view('leads.report', [
            'lead'                  => $lead,
            'report'                => $report,
            'scores'                => $scores,
            'stats'                 => $stats,
            'indicators'            => $indicators,
            'indicators_labels'     => $indicators_labels,
            'website'               => $website
        ]);

        // generate PDF
        $report_name = 'report_' . snake_case($lead->name);

        $pdfOptions = new Options();
        //$pdfOptions->setIsRemoteEnabled('true');
        $pdfOptions->setIsHtml5ParserEnabled('true');

        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->setOptions($pdfOptions);
        $dompdf->render();
        $dompdf->stream($report_name);

        //Storage::delete('test.png');

        // return view (for testing purposes)
        return view('leads.report', [
            'lead'          => $lead,
            'report'        => $report,
            'scores'        => $scores,
            'stats'         => $stats,
            'indicators'    => $indicators,
            'indicators_labels'     => $indicators_labels,
            'website'       => $website
        ]);
    }
}