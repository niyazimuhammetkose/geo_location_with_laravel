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

    'accepted' => ':attribute alanı kabul edilmelidir.',
    'accepted_if' => ':attribute alanı, :other değeri :value olduğunda kabul edilmelidir.',
    'active_url' => ':attribute alanı geçerli bir URL olmalıdır.',
    'after' => ':attribute alanı :date değerinden sonraki bir tarih olmalıdır.',
    'after_or_equal' => ':attribute alanı :date tarihinden sonra veya ona eşit bir tarih olmalıdır.',
    'alpha' => ':attribute alanı yalnızca harf içermelidir.',
    'alpha_dash' => ':attribute alanı yalnızca harf, rakam, tire ve alt çizgi içermelidir.',
    'alpha_num' => ':attribute alanı yalnızca harf ve rakamlardan oluşmalıdır.',
    'array' => ':attribute alanı bir dizi olmalıdır.',
    'ascii' => ':attribute alanı yalnızca tek baytlık alfanümerik karakterler ve semboller içermelidir.',
    'before' => ':attribute alanı :date değerinden önceki bir tarih olmalıdır.',
    'before_or_equal' => ':attribute alanı :date tarihinden önce veya ona eşit bir tarih olmalıdır.',
    'between' => [
        'array' => ':attribute alanı :min ile :max arasında öğe içermelidir.',
        'file' => ':attribute alanı :min ile :max kilobayt arasında olmalıdır.',
        'numeric' => ':attribute alanı :min ile :max arasında olmalıdır.',
        'string' => ':attribute alanı :min ile :max karakterleri arasında olmalıdır.',
    ],
    'boolean' => ':attribute alanı true veya false olmalıdır.',
    'can' => ':attribute alanı yetkisiz bir değer içeriyor.',
    'confirmed' => ':attribute alanı onayı eşleşmiyor.',
    'contains' => ':attribute alanında gerekli bir değer eksik.',
    'current_password' => 'Şifre hatalı.',
    'date' => ':attribute alanı geçerli bir tarih olmalıdır.',
    'date_equals' => ':attribute alanı :date değerine eşit bir tarih olmalıdır.',
    'date_format' => ':attribute alanı :format biçimiyle eşleşmelidir.',
    'decimal' => ':attribute alanı :decimal ondalık basamaklara sahip olmalıdır.',
    'declined' => ':attribute alanı reddedilmelidir.',
    'declined_if' => ':attribute alanı, :other değeri :value olduğunda reddedilmelidir.',
    'different' => ':attribute alanı ve :other alanı farklı olmalıdır.',
    'digits' => ':attribute alanı :digits rakamlarından oluşmalıdır.',
    'digits_between' => ':attribute alanı :min ile :max arasında rakamlardan oluşmalıdır.',
    'dimensions' => ':attribute alanı geçersiz resim boyutlarına sahip.',
    'distinct' => ':attribute alanı yinelenen bir değere sahip.',
    'doesnt_end_with' => ':attribute alanı aşağıdakilerden biriyle bitmemelidir: :values.',
    'doesnt_start_with' => ':attribute alanı aşağıdakilerden biriyle başlamamalıdır: :values.',
    'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
    'ends_with' => ':attribute alanı aşağıdakilerden biriyle bitmelidir: :values.',
    'enum' => 'Seçilen :attribute geçersiz.',
    'exists' => 'Seçilen :attribute geçersiz.',
    'extensions' => ':attribute alanı aşağıdaki uzantılardan birine sahip olmalıdır: :values.',
    'file' => ':attribute alanı bir dosya olmalıdır.',
    'filled' => ':attribute alanının bir değeri olmalıdır.',
    'gt' => [
        'array' => ':attribute alanı :value öğesinden fazlasını içermelidir.',
        'file' => ':attribute alanı :value kilobayttan büyük olmalıdır.',
        'numeric' => ':attribute alanı :value değerinden büyük olmalıdır.',
        'string' => ':attribute alanı :value karakterlerinden büyük olmalıdır.',
    ],
    'gte' => [
        'array' => ':attribute alanı :value veya daha fazla öğeye sahip olmalıdır.',
        'file' => ':attribute alanı :value kilobayttan büyük veya eşit olmalıdır.',
        'numeric' => ':attribute alanı :value değerinden büyük veya eşit olmalıdır.',
        'string' => ':attribute alanı :value karakterlerinden büyük veya eşit olmalıdır.',
    ],
    'hex_color' => ':attribute alanı geçerli bir onaltılık renk olmalıdır.',
    'image' => ':attribute alanı bir resim olmalıdır.',
    'in' => 'Seçilen :attribute geçersiz.',
    'in_array' => ':attribute alanı :other içinde bulunmalıdır.',
    'integer' => ':attribute alanı tam sayı olmalıdır.',
    'ip' => ':attribute alanı geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute alanı geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute alanı geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute alanı geçerli bir JSON dizesi olmalıdır.',
    'list' => ':attribute alanı bir liste olmalıdır.',
    'lowercase' => ':attribute alanı küçük harfle yazılmalıdır.',
    'lt' => [
        'array' => ':attribute alanı :value değerinden az öğe içermelidir.',
        'file' => ':attribute alanı :value kilobayttan küçük olmalıdır.',
        'numeric' => ':attribute alanı :value değerinden küçük olmalıdır.',
        'string' => ':attribute alanı :value karakterinden az olmalıdır.',
    ],
    'lte' => [
        'array' => ':attribute alanı en fazla :value öğesi içerebilir.',
        'file' => ':attribute alanı :value kilobayttan küçük veya eşit olmalıdır.',
        'numeric' => ':attribute alanı :value değerinden küçük veya eşit olmalıdır.',
        'string' => ':attribute alanı :value karakterinden küçük veya eşit olmalıdır.',
    ],
    'mac_address' => ':attribute alanı geçerli bir MAC adresi olmalıdır.',
    'max' => [
        'array' => ':attribute alanı :max\'tan fazla öğeye sahip olamaz.',
        'file' => ':attribute alanı :max kilobayttan büyük olmamalıdır.',
        'numeric' => ':attribute alanı :max değerinden büyük olmamalıdır.',
        'string' => ':attribute alanı :max karakterden büyük olmamalıdır.',
    ],
    'max_digits' => ':attribute alanı :max\'tan fazla rakam içeremez.',
    'mimes' => ':attribute alanı :values türünde bir dosya olmalıdır.',
    'mimetypes' => ':attribute alanı :values türünde bir dosya olmalıdır.',
    'min' => [
        'array' => ':attribute alanı en az :min öğeye sahip olmalıdır.',
        'file' => ':attribute alanı en az :min kilobayt olmalıdır.',
        'numeric' => ':attribute alanı en az :min olmalıdır.',
        'string' => ':attribute alanı en az :min karakter uzunluğunda olmalıdır.',
    ],
    'min_digits' => ':attribute alanı en az :min rakam içermelidir.',
    'missing' => ':attribute alanı eksik olmalı.',
    'missing_if' => ':other ifadesi :value olduğunda :attribute alanı eksik olmalıdır.',
    'missing_unless' => ':attribute alanı, :other değeri :value olmadığı sürece eksik olmalıdır.',
    'missing_with' => ':values mevcut olduğunda :attribute alanı eksik olmalıdır.',
    'missing_with_all' => ':values mevcut olduğunda :attribute alanı eksik olmalıdır.',
    'multiple_of' => ':attribute alanı :value\'nun katı olmalıdır.',
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => ':attribute alan biçimi geçersiz.',
    'numeric' => ':attribute alanı bir sayı olmalıdır.',
    'password' => [
        'letters' => ':attribute alanı en az bir harf içermelidir.',
        'mixed' => ':attribute alanı en az bir büyük harf ve bir küçük harf içermelidir.',
        'numbers' => ':attribute alanı en az bir rakam içermelidir.',
        'symbols' => ':attribute alanı en az bir sembol içermelidir.',
        'uncompromised' => 'Verilen :attribute bir veri sızıntısında ortaya çıktı. Lütfen farklı bir :attribute seçin.',
    ],
    'present' => ':attribute alanı mevcut olmalıdır.',
    'present_if' => ':other değeri :value olduğunda :attribute alanı mevcut olmalıdır.',
    'present_unless' => ':attribute alanı, :other değeri :value olmadığı sürece mevcut olmalıdır.',
    'present_with' => ':values mevcut olduğunda :attribute alanı da mevcut olmalıdır.',
    'present_with_all' => ':attribute alanı, :values mevcut olduğunda mevcut olmalıdır.',
    'prohibited' => ':attribute alanı yasaktır.',
    'prohibited_if' => ':attribute alanı, :other değeri :value olduğunda yasaktır.',
    'prohibited_unless' => ':attribute alanı, :other öğesi :values içinde olmadığı sürece yasaktır.',
    'prohibits' => ':attribute alanı :other özelliğinin bulunmasını yasaklar.',
    'regex' => ':attribute alan biçimi geçersiz.',
    'required' => ':attribute alanı zorunludur.',
    'required_array_keys' => ':attribute alanı :values için girdiler içermelidir.',
    'required_if' => ':attribute alanı, :other değeri :value olduğunda zorunludur.',
    'required_if_accepted' => ':attribute alanı :other kabul edildiğinde zorunludur.',
    'required_if_declined' => ':attribute alanı :other reddedildiğinde zorunludur.',
    'required_unless' => ':attribute alanı, :other değeri :values içinde olmadığı sürece zorunludur.',
    'required_with' => ':attribute alanı, :values mevcut olduğunda zorunludur.',
    'required_with_all' => ':attribute alanı :values mevcut olduğunda zorunludur.',
    'required_without' => ':attribute alanı, :values mevcut olmadığında zorunludur.',
    'required_without_all' => ':attribute alanı, :values değerlerinden hiçbiri mevcut olmadığında zorunludur.',
    'same' => ':attribute alanı :other ile eşleşmelidir.',
    'size' => [
        'array' => ':attribute alanı :size öğelerini içermelidir.',
        'file' => ':attribute alanı :size kilobayt olmalıdır.',
        'numeric' => ':attribute alanı :size olmalıdır.',
        'string' => ':attribute alanı :size karakter uzunluğunda olmalıdır.',
    ],
    'starts_with' => ':attribute alanı aşağıdakilerden biriyle başlamalıdır: :values.',
    'string' => ':attribute alanı bir dize olmalıdır.',
    'timezone' => ':attribute alanı geçerli bir zaman dilimi olmalıdır.',
    'unique' => ':attribute zaten alınmış.',
    'uploaded' => ':attribute yüklenemedi.',
    'uppercase' => ':attribute alanı büyük harfle yazılmalıdır.',
    'url' => ':attribute alanı geçerli bir URL olmalıdır.',
    'ulid' => ':attribute alanı geçerli bir ULID olmalıdır.',
    'uuid' => ':attribute alanı geçerli bir UUID olmalıdır.',

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
