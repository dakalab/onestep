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

    'accepted'             => ':attribute 必须被接受。',
    'active_url'           => ':attribute 不是一个有效的URL。',
    'after'                => ':attribute 必须是一个在 :date 之后的日期。',
    'after_or_equal'       => ':attribute 必须是一个在 :date 当天或者之后的日期。',
    'alpha'                => ':attribute 只能包含字母。',
    'alpha_dash'           => ':attribute 只能包含字母、数字和下划线。',
    'alpha_num'            => ':attribute 只能包含字母和数字。',
    'array'                => ':attribute 必须是一个数组。',
    'before'               => ':attribute 必须是一个在 :date 之前的日期。',
    'before_or_equal'      => ':attribute 必须是一个在 :date 当天或者之前的日期。',
    'between'              => [
        'numeric' => ':attribute 必须在 :min 到 :max 之间。',
        'file'    => ':attribute 必须在 :min 到 :max 千字节之间。',
        'string'  => ':attribute 必须在 :min 到 :max 个字符',
        'array'   => ':attribute 必须拥有 :min 到 :max 个项目。',
    ],
    'boolean'              => ':attribute 字段必须是 true 或者 false。',
    'confirmed'            => ':attribute 确认信息不相符。',
    'date'                 => ':attribute 不是一个有效的日期。',
    'date_formate'         => ':attribute 不匹配格式 :格式。',
    'different'            => ':attribute 和 :other 必须不同。',
    'digits'               => ':attribute 必须是 :digits 个数字。',
    'digits_between'       => ':attribute 必须是在 :min 和 :max 之间的数字。',
    'dimensions'           => ':attribute 图片尺寸非法。',
    'distinct'             => ':attribute 字段有重复值。',
    'email'                => ':attribute 必须是一个有效的邮箱地址。',
    'exists'               => '选中的 :attribute 非法。',
    'file'                 => ':attribute 必须是一个文件。',
    'filled'               => ':attribute 字段必须有值。',
    'image'                => ':attribute 必须是一张图片',
    'in'                   => '选中的 :attribute 非法。',
    'in_array'             => ':attribute 字段在 :other 中不存在。',
    'integer'              => ':attribute 必须是一个整数。',
    'ip'                   => ':attribute 必须是一个有效的IP地址。',
    'ipv4'                 => ':attribute 必须是一个有效的IPv4地址。',
    'ipv6'                 => ':attribute 必须是一个有效的IPv6地址。',
    'json'                 => ':attribute 必须是一个有效的JSON字符串。',
    'max'                  => [
        'numeric' => ':attribute 不能超过 :max。',
        'file'    => ':attribute 不能超过 :max 千字节。',
        'string'  => ':attribute 不能超过 :max 个字符。',
        'array'   => ':attribute 不能超过 :max 个项目。',
    ],
    'mimes'                => ':attribute 必须是一个 :values 类型的文件。',
    'mimetypes'            => ':attribute 必须是一个 :values 类型的文件。',
    'min'                  => [
        'numeric' => ':attribute 必须不小于 :min。',
        'file'    => ':attribute 必须不小于 :min 千字节。',
        'string'  => ':attribute 必须不小于 :min 个字符。',
        'array'   => ':attribute 必须至少拥有 :min 个项目。',
    ],
    'not_in'               => '选中的 :attribute 非法。',
    'not_regex'            => ':attribute 格式非法。',
    'numeric'              => ':attribute 必须是一个数值。',
    'present'              => ':attribute 字段必须是present。',
    'regex'                => ':attribute 格式非法。',
    'required'             => ':attribute 字段必填。',
    'required_if'          => ':attribute 字段当 :other 是 :value 时必填。',
    'required_unless'      => ':attribute 字段必填，除非 :other 是在 :values。',
    'required_with'        => ':attribute 字段当 :values 存在时必填。',
    'required_with_all'    => ':attribute 字段当 :values 存在时必填。',
    'required_without'     => ':attribute 字段当 :values 不存在时必填。',
    'required_without_all' => ':attribute 字段当 :values 都不存在时必填。',
    'same'                 => ':attribute 和 :other 必须相符。',
    'size'                 => [
        'numeric' => ':attribute 必须是 :size。',
        'file'    => ':attribute 必须是 :size 千字节。',
        'string'  => ':attribute 必须是 :size 个字符。',
        'array'   => ':attribute 必须包含 :size 个项目。',
    ],
    'string'               => ':attribute 必须是一个字符串。',
    'timezone'             => ':attribute 必须是个有效的时区。',
    'unique'               => ':attribute 已经被占用。',
    'uploaded'             => ':attribute 上传失败。',
    'url'                  => ':attribute 格式错误。',

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

    'custom'               => [
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

    'attributes'           => [],

];
