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

    'accepted'             => 'Inputan :attribute harus diterima.',
    'active_url'           => 'Inputan :attribute bukan URL yang sah.',
    'after'                => 'Inputan :attribute harus tanggal setelah :date.',
    'after_or_equal'       => 'Inputan :attribute harus tanggal setelah atau sama dengan :date.',
    'alpha'                => 'Inputan :attribute hanya boleh berisi huruf.',
    'alpha_dash'           => 'Inputan :attribute hanya boleh berisi huruf, angka, dan strip.',
    'alpha_num'            => 'Inputan :attribute hanya boleh berisi huruf dan angka.',
    'array'                => 'Inputan :attribute harus berupa sebuah array.',
    'before'               => 'Inputan :attribute harus tanggal sebelum :date.',
    'before_or_equal'      => 'Inputan :attribute harus tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => 'Inputan :attribute harus antara :min dan :max.',
        'file'    => 'Inputan :attribute harus antara :min dan :max kilobytes.',
        'string'  => 'Inputan :attribute harus antara :min dan :max karakter.',
        'array'   => 'Inputan :attribute harus antara :min dan :max item.',
    ],
    'boolean'              => 'Inputan :attribute harus berupa true atau false',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => 'Inputan :attribute bukan tanggal yang valid.',
    'date_equals'          => 'Inputan :attribute harus tanggal yang sama dengan :date.',
    'date_format'          => 'Inputan :attribute tidak cocok dengan format :format.',
    'different'            => 'Inputan :attribute dan :other harus berbeda.',
    'digits'               => 'Inputan :attribute harus berupa angka :digits.',
    'digits_between'       => 'Inputan :attribute harus antara angka :min dan :max.',
    'dimensions'           => 'Inputan :attribute harus merupakan dimensi gambar yang sah.',
    'distinct'             => 'Inputan :attribute memiliki nilai yang duplikat.',
    'email'                => 'Inputan :attribute harus berupa alamat surel yang valid.',
    'ends_with'            => 'Inputan :attribute harus diakhiri dengan: :values.',
    'exists'               => 'Inputan :attribute yang dipilih tidak valid.',
    'file'                 => 'Inputan :attribute harus berupa file.',
    'filled'               => 'Inputan :attribute wajib diisi.',
    'gt' => [
        'numeric'   => 'Inputan :attribute harus lebih besar dari :value.',
        'file'      => 'Inputan :attribute harus lebih besar dari :value kilobytes.',
        'string'    => 'Inputan :attribute harus lebih besar dari :value karakter.',
        'array'     => 'Inputan :attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric'   => 'Inputan :attribute harus lebih besar dari atau sama dengan :value.',
        'file'      => 'Inputan :attribute harus lebih besar dari atau sama dengan :value kilobytes.',
        'string'    => 'Inputan :attribute harus lebih besar dari atau sama dengan :value karakter.',
        'array'     => 'Inputan :attribute harus memiliki :value item atau lebih.',
    ],
    'image'                => 'Inputan :attribute harus berupa gambar.',
    'in'                   => 'Inputan :attribute yang dipilih tidak valid.',
    'in_array'             => 'Inputan :attribute tidak terdapat dalam :other.',
    'integer'              => 'Inputan :attribute harus merupakan bilangan bulat.',
    'ip'                   => 'Inputan :attribute harus berupa alamat IP yang valid.',
    'ipv4'                 => 'Inputan :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                 => 'Inputan :attribute harus berupa alamat IPv6 yang valid.',
    'json'                 => 'Inputan :attribute harus berupa JSON string yang valid.',
    'lt' => [
        'numeric'   => 'Inputan :attribute harus kurang dari :value.',
        'file'      => 'Inputan :attribute harus kurang dari :value kilobytes.',
        'string'    => 'Inputan :attribute harus kurang dari :value karakter.',
        'array'     => 'Inputan :attribute harus memiliki kurang dari :value item.',
    ],
    'lte' => [
        'numeric'   => 'Inputan :attribute harus kurang dari atau sama dengan :value.',
        'file'      => 'Inputan :attribute harus kurang dari atau sama dengan :value kilobytes.',
        'string'    => 'Inputan :attribute harus kurang dari atau sama dengan :value karakter.',
        'array'     => 'Inputan :attribute tidak boleh lebih dari :value item.',
    ],
    'max'                  => [
        'numeric' => 'Inputan :attribute seharusnya tidak lebih dari :max.',
        'file'    => 'Inputan :attribute seharusnya tidak lebih dari :max kilobytes.',
        'string'  => 'Inputan :attribute seharusnya tidak lebih dari :max karakter.',
        'array'   => 'Inputan :attribute seharusnya tidak lebih dari :max item.',
    ],
    'mimes'                => 'Inputan :attribute harus dokumen berjenis : :values.',
    'mimetypes'            => 'Inputan :attribute harus berupa file bertipe: :values.',
    'min'                  => [
        'numeric' => 'Inputan :attribute harus minimal :min.',
        'file'    => 'Inputan :attribute harus minimal :min kilobytes.',
        'string'  => 'Inputan :attribute harus minimal :min karakter.',
        'array'   => 'Inputan :attribute harus minimal :min item.',
    ],
    'not_in'               => 'Inputan :attribute yang dipilih tidak valid.',
    'not_regex'            => 'Inputan :attribute format tidak valid.',
    'numeric'              => 'Inputan :attribute harus berupa angka.',
    'password'             => 'Kata sandi tidak benar',
    'present'              => 'Inputan :attribute wajib ada.',
    'regex'                => 'Format Inputan :attribute tidak valid.',
    'required'             => 'Inputan :attribute wajib diisi.',
    'required_if'          => 'Inputan :attribute wajib diisi bila :other adalah :value.',
    'required_unless'      => 'Inputan :attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'        => 'Inputan :attribute wajib diisi bila terdapat :values.',
    'required_with_all'    => 'Inputan :attribute wajib diisi bila terdapat :values.',
    'required_without'     => 'Inputan :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Inputan :attribute wajib diisi bila tidak terdapat ada :values.',
    'same'                 => 'Inputan :attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => 'Inputan :attribute harus berukuran :size.',
        'file'    => 'Inputan :attribute harus berukuran :size kilobyte.',
        'string'  => 'Inputan :attribute harus berukuran :size karakter.',
        'array'   => 'Inputan :attribute harus mengandung :size item.',
    ],
    'starts_with'          => 'Inputan :attribute harus dimulai dengan: :values.',
    'string'               => 'Inputan :attribute harus berupa string.',
    'timezone'             => 'Inputan :attribute harus berupa zona waktu yang valid.',
    'unique'               => 'Inputan :attribute sudah ada sebelumnya.',
    'uploaded'             => 'Inputan :attribute gagal mengunggah.',
    'url'                  => 'Format Inputan :attribute tidak valid.',
    'uuid'                 => 'Inputan :attribute harus berupa UUID yang valid.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
