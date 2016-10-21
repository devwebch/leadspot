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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // get the tour param
        $tour = $request->input('tour');

        // get search categories
        $categories = trans('search.categories');
        asort($categories);

        return view('leads.search', [
            'tour'          => $tour,
            'categories'    => $categories
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
        $user = $request->user();
        if ( $lead->user_id != $user->id ) { return redirect('/'); }

        // retrieve lead status
        $status = config('constants.lead.status');

        $leadService = new LeadServiceController();

        $status_classes = [
            0   => '',
            1   => 'label-warning',
            2   => 'label-success',
            3   => 'label-danger'
        ];

        $stored_contacts    = Contact::where('lead_id', $lead->id)->count();
        $available_contacts = $stored_contacts;

        if ( $stored_contacts == 0 ) {
            $available_contacts = $leadService->checkLeadEmails($lead);
        }

        return view('leads.view', [
            'lead'                  => $lead,
            'status'                => $status,
            'status_classes'        => $status_classes,
            'stored_contacts'       => $stored_contacts,
            'available_contacts'    => $available_contacts,
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

        $status_classes = [
            0   => '',
            1   => 'label-warning',
            2   => 'label-success',
            3   => 'label-danger'
        ];

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

        $status_classes = [
            0   => '',
            1   => 'text-warning',
            2   => 'text-success',
            3   => 'text-danger'
        ];

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

        $status_classes = [
            0   => '',
            1   => 'text-warning',
            2   => 'text-success',
            3   => 'text-danger'
        ];

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

        // store view
        $view           = view('leads.report', [
            'lead'                  => $lead,
            'report'                => $report,
            'scores'                => $scores,
            'stats'                 => $stats,
            'indicators'            => $indicators,
            'indicators_labels'     => $indicators_labels,
            'website'               => $website,
        ]);

        // generate PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('report');

        // return view (for testing purposes)
        return view('leads.report', [
            'lead'          => $lead,
            'report'        => $report,
            'scores'        => $scores,
            'stats'         => $stats,
            'indicators'    => $indicators,
            'indicators_labels'     => $indicators_labels,
            'website'       => $website,
        ]);
    }
}