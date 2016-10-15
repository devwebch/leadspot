<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'Le :attribute doit être accepté.',
    'active_url'           => 'Le :attribute doit avoir une URL valide.',
    'after'                => 'Le :attribute doit avoir une date après :date.',
    'alpha'                => 'Le :attribute ne peux contenir que des lettres.',
    'alpha_dash'           => 'Le :attribute ne peux contenir que des lettre, nombre, et tirets.',
    'alpha_num'            => 'Le :attribute ne peux contenir que des lettres ou chiffres.',
    'array'                => 'Le :attribute doit être un tableau.',
    'before'               => 'Le :attribute doit être une date avant :date.',
    'between'              => [
        'numeric' => 'Le :attribute doit être entre :min et :max.',
        'file'    => 'Le :attribute doit être entre :min et :max kilobytes.',
        'string'  => 'Le :attribute doit être entre :min et :max characters.',
        'array'   => 'Le :attribute doit avoir entre :min et :max objets.',
    ],
    'boolean'              => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed'            => 'Le :attribute confirmation does not match.',
    'date'                 => 'Le :attribute doit être une date valide.',
    'date_format'          => 'Le :attribute ne correspond pas au format :format.',
    'different'            => 'Le :attribute et :other doivent être différent.',
    'digits'               => 'Le :attribute doit avoir :digits numéros.',
    'digits_between'       => 'Le :attribute doit avoir entre :min et :max numéros.',
    'dimensions'           => 'Le :attribute a des dimensions invalides.',
    'distinct'             => 'Le champ :attribute a une valeur dupliquée.',
    'email'                => 'Le :attribute doit être une adresse e-mail valide.',
    'exists'               => 'Le :attribute sélectionné est invalide.',
    'file'                 => 'Le :attribute doit être un fichier.',
    'filled'               => 'Le champ :attribute est requis.',
    'image'                => 'Le :attribute doit être une image.',
    'in'                   => 'Le :attribute sélectionné est invalide.',
    'in_array'             => 'Le champ :attribute ne doit pas exister dans :other.',
    'integer'              => 'Le :attribute doit être un entier.',
    'ip'                   => 'Le :attribute doit être une adresse IP valide.',
    'json'                 => 'Le :attribute doit être un JSON valide.',
    'max'                  => [
        'numeric' => 'Le :attribute ne doit pas être plus grand que :max.',
        'file'    => 'Le :attribute ne doit pas être plus grand que :max kilobytes.',
        'string'  => 'Le :attribute ne doit pas être plus grand que :max caractères.',
        'array'   => 'Le :attribute ne doit pas avoir plus que :max objets.',
    ],
    'mimes'                => 'Le :attribute doit être un fichier de type type: :values.',
    'min'                  => [
        'numeric' => 'Le :attribute doit être au moins :min.',
        'file'    => 'Le :attribute doit être au moins :min kilobytes.',
        'string'  => 'Le :attribute doit être au moins :min caractères.',
        'array'   => 'Le :attribute doit avoir au moins :min objets.',
    ],
    'not_in'               => 'Le :attribute sélectionné est invalide.',
    'numeric'              => 'Le :attribute doit être un nombre.',
    'present'              => 'Le champ :attribute doit être présent.',
    'regex'                => 'Le champ :attribute a un format invalide.',
    'required'             => 'Le champ :attribute est requis.',
    'required_if'          => 'Le champ :attribute est requis quand :other est :value.',
    'required_unless'      => 'Le champ :attribute est requis si :other est parmis :values.',
    'required_with'        => 'Le champ :attribute est requis quand :values est présent.',
    'required_with_all'    => 'Le champ :attribute est requis quand :values est présent.',
    'required_without'     => 'Le champ :attribute est requis quand :values n\'est pas présent.',
    'required_without_all' => 'Le champ :attribute est requis quand aucune des :values est présent.',
    'same'                 => 'Le :attribute et :other doivent correspondre.',
    'size'                 => [
        'numeric' => 'Le :attribute doit être :size.',
        'file'    => 'Le :attribute doit être de :size kilobytes.',
        'string'  => 'Le :attribute doit avoir :size caractères.',
        'array'   => 'Le :attribute doit avoir :size objets.',
    ],
    'string'               => 'Le :attribute doit contenir des caractères.',
    'timezone'             => 'Le :attribute doit être une zone valide.',
    'unique'               => 'Le :attribute est déjà pris.',
    'url'                  => 'Le format de :attribute est invalide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
