<?php

return array(

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

    'accepted'             => ':attribute 必须为准许的。',
    'active_url'           => ':attribute 不是有效的 URL。',
    'after'                => ':attribute 必须是在 :date 之后的日期。',
    'alpha'                => ':attribute 只能包含字母。',
    'alpha_dash'           => ':attribute 只能包含字母，数字和短横线。',
    'alpha_num'            => ':attribute 只能包含字母和数字。',
    'array'                => ':attribute 必须是数组。',
    'before'               => ':attribute 必须是在 :date 之前的日期。',
    'between.numeric'      => ':attribute 必须在 :min 到 :max 之间。',
    'between.file'         => ':attribute 文件的大小必须在 :min 到 :max KB 之间。',
    'between.string'       => ':attribute 的长度必须在 :min 到 :max 字符之间。',
    'between.array'        => ':attribute 数组的长度必须在 :min 到 :max 之间。',
    'boolean'              => ':attribute 必须是 true 或 false 。',
    'confirmed'            => ':attribute 重复确认不匹配。',
    'date'                 => ':attribute 不是有效的日期。',
    'date_format'          => ':attribute 不符合日期格式 :format 。',
    'different'            => ':attribute 和 :other 必须是不同的。',
    'digits'               => ':attribute 必须有 :digits 位数。',
    'digits_between'       => ':attribute 必须在 :min 到 :max 位数之间。',
    'email'                => ':attribute 必须是有效的电子邮件地址。',
    'exists'               => ':attribute 不存在。',
    'filled'               => ':attribute 是必需的。',
    'image'                => ':attribute 必须是图片文件。',
    'in'                   => ':attribute 不是有效值。',
    'integer'              => ':attribute 必须是整数。',
    'ip'                   => ':attribute 必须是有效的 IP 地址。',
    'json'                 => ':attribute 必须是有效的 JSON 字符串。',
    'max.numeric'          => ':attribute 不能超过 :max 。',
    'max.file'             => ':attribute 文件的大小不能超过 :max KB 。',
    'max.string'           => ':attribute 的长度不能超过 :max 字符。',
    'max.array'            => ':attribute 数组的长度不能超过 :max 。',
    'mimes'                => ':attribute 文件必须是以下类型： :values 。',
    'min.numeric'          => ':attribute 必须大于 :min 。',
    'min.file'             => ':attribute 文件的大小必须大于 :min KB 。',
    'min.string'           => ':attribute 的长度必须大于 :min 字符。',
    'min.array'            => ':attribute 数组的长度必须大于 :min 。',
    'not_in'               => ':attribute 不是有效值。',
    'numeric'              => ':attribute 必须是数字。',
    'regex'                => '正则表达式 :attribute 的格式不正确。',
    'required'             => ':attribute 是必需的。',
    'required_if'          => '当 :other 是 :value 时，:attribute 是必需的。',
    'required_unless'      => ':attribute 是必需的，除非 :other 是 :values 之中的某个。',
    'required_with'        => '当 :values 存在时， :attribute 是必需的。',
    'required_with_all'    => '当 :values 存在时， :attribute 是必需的。',
    'required_without'     => '当 :values 不存在时， :attribute 是必需的。',
    'required_without_all' => '当 :values 的任何一个都不存在时， :attribute 是必需的。',
    'same'                 => ':attribute 和 :other 必须匹配。',
    'size.numeric'         => ':attribute 必须是 :size 。',
    'size.file'            => ':attribute 文件的大小必须为 :size KB 。',
    'size.string'          => ':attribute 的长度必须是 :size 字符。',
    'size.array'           => ':attribute 数组必须包含 :size 个项。',
    'string'               => ':attribute 必须是字符串。',
    'timezone'             => ':attribute 必须是有效的时区。',
    'unique'               => ':attribute 已被占用。',
    'url'                  => ':attribute 的 URL 格式不正确。',

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

    // 'custom' => array(
    //     'attribute-name' => array(
    //         'rule-name' => 'nope',
    //     ),
    // ),

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

    // 'attributes' => array(),

);
