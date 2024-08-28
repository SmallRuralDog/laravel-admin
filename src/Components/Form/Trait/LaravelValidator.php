<?php

namespace SmallRuralDog\Admin\Components\Form\Trait;

/**
 * Below is a list of all available validation rules and their function:
 *
 * Accepted
 * Accepted If
 * Active URL
 * After (Date)
 * After Or Equal (Date)
 * Alpha
 * Alpha Dash
 * Alpha Numeric
 * Array
 * Ascii
 * Bail
 * Before (Date)
 * Before Or Equal (Date)
 * Between
 * Boolean
 * Confirmed
 * Contains
 * Current Password
 * Date
 * Date Equals
 * Date Format
 * Decimal
 * Declined
 * Declined If
 * Different
 * Digits
 * Digits Between
 * Dimensions (Image Files)
 * Distinct
 * Doesnt Start With
 * Doesnt End With
 * Email
 * Ends With
 * Enum
 * Exclude
 * Exclude If
 * Exclude Unless
 * Exclude With
 * Exclude Without
 * Exists (Database)
 * Extensions
 * File
 * Filled
 * Greater Than
 * Greater Than Or Equal
 * Hex Color
 * Image (File)
 * In
 * In Array
 * Integer
 * IP Address
 * JSON
 * Less Than
 * Less Than Or Equal
 * List
 * Lowercase
 * MAC Address
 * Max
 * Max Digits
 * MIME Types
 * MIME Type By File Extension
 * Min
 * Min Digits
 * Missing
 * Missing If
 * Missing Unless
 * Missing With
 * Missing With All
 * Multiple Of
 * Not In
 * Not Regex
 * Nullable
 * Numeric
 * Present
 * Present If
 * Present Unless
 * Present With
 * Present With All
 * Prohibited
 * Prohibited If
 * Prohibited Unless
 * Prohibits
 * Regular Expression
 * Required
 * Required If
 * Required If Accepted
 * Required If Declined
 * Required Unless
 * Required With
 * Required With All
 * Required Without
 * Required Without All
 * Required Array Keys
 * Same
 * Size
 * Sometimes
 * Starts With
 * String
 * Timezone
 * Unique (Database)
 * Uppercase
 * URL
 * ULID
 * UUID
 */
trait LaravelValidator
{

    /**
     * Accepted
     * The field under validation must be "yes", "on", 1, "1", true, or "true". This is useful for validating "Terms of Service" acceptance or similar fields.
     * 待验证字段必须是 「yes」 ，「on」 ，1 或 true。这对于验证「服务条款」的接受或类似字段时很有用
     */
    public function vAccepted(bool $enable = true): self
    {
        if ($enable) $this->rule->add('accepted');
        return $this;
    }

    /**
     * Accepted If
     * The field under validation must be accepted if another field is equal to a given value.
     * 如果另一个字段等于给定值，则必须接受验证字段
     */
    public function vAcceptedIf(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('accepted_if:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Active URL
     * The field under validation must be a valid URL according to the checkdnsrr PHP function.
     * 根据 checkdnsrr PHP 函数，待验证字段必须是有效的 URL
     */
    public function vActiveUrl(bool $enable = true): self
    {
        if ($enable) $this->rule->add('active_url');
        return $this;
    }

    /**
     * After (Date)
     * The field under validation must be a value after a given date. The dates will be passed into the PHP strtotime function.
     * 待验证字段必须是给定日期之后的值。日期将传递到 PHP strtotime 函数
     */
    public function vAfter(string $date, bool $enable = true): self
    {
        if ($enable) $this->rule->add('after:' . $date);
        return $this;
    }

    /**
     * After Or Equal (Date)
     * The field under validation must be a value after or equal to the given date. For more information, see the after rule.
     * 待验证字段必须是给定日期之后或等于给定日期的值。有关更多信息，请参见 after 规则
     */
    public function vAfterOrEqual(string $date, bool $enable = true): self
    {
        if ($enable) $this->rule->add('after_or_equal:' . $date);
        return $this;
    }

    /**
     * Alpha
     * The field under validation must be entirely alphabetic characters.
     * 待验证字段必须完全是字母字符
     */
    public function vAlpha(bool $enable = true): self
    {
        if ($enable) $this->rule->add('alpha');
        return $this;
    }

    /**
     * Alpha Dash
     * The field under validation may have alpha-numeric characters, as well as dashes and underscores.
     * 待验证字段可以包含字母数字字符，以及破折号和下划线
     */
    public function vAlphaDash(bool $enable = true): self
    {
        if ($enable) $this->rule->add('alpha_dash');
        return $this;
    }

    /**
     * Alpha Numeric
     * The field under validation must be entirely alpha-numeric characters.
     * 待验证字段必须完全是字母数字字符
     */
    public function vAlphaNumeric(bool $enable = true): self
    {
        if ($enable) $this->rule->add('alpha_num');
        return $this;
    }

    /**
     * Array
     * The field under validation must be a PHP array.
     * 待验证字段必须是 PHP 数组
     */
    public function vArray(bool $enable = true): self
    {
        if ($enable) $this->rule->add('array');
        return $this;
    }

    /**
     * Ascii
     * The field under validation must be entirely ASCII characters.
     * 待验证字段必须完全是 ASCII 字符
     */
    public function vAscii(bool $enable = true): self
    {
        if ($enable) $this->rule->add('ascii');
        return $this;
    }

    /**
     * Bail
     * Stop running validation rules after the first validation failure.
     * 在第一次验证失败后停止运行验证规则
     */
    public function vBail(bool $enable = true): self
    {
        if ($enable) $this->rule->add('bail');
        return $this;
    }

    /**
     * Before (Date)
     * The field under validation must be a value preceding the given date. The dates will be passed into the PHP strtotime function.
     * 待验证字段必须是给定日期之前的值。日期将传递到 PHP strtotime 函数
     */
    public function vBefore(string $date, bool $enable = true): self
    {
        if ($enable) $this->rule->add('before:' . $date);
        return $this;
    }

    /**
     * Before Or Equal (Date)
     * The field under validation must be a value preceding or equal to the given date. For more information, see the before rule.
     * 待验证字段必须是给定日期之前或等于给定日期的值。有关更多信息，请参见 before 规则
     */
    public function vBeforeOrEqual(string $date, bool $enable = true): self
    {
        if ($enable) $this->rule->add('before_or_equal:' . $date);
        return $this;
    }

    /**
     * Between
     * The field under validation must have a size between the given min and max. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
     * 待验证字段的大小必须在给定的最小值和最大值之间。字符串、数字、数组和文件的评估方式与 size 规则相同
     */
    public function vBetween(int $min, int $max, bool $enable = true): self
    {
        if ($enable) $this->rule->add('between:' . $min . ',' . $max);
        return $this;
    }

    /**
     * Boolean
     * The field under validation must be able to be cast as a boolean. Accepted input are true, false, 1, 0, "1", and "0".
     * 待验证字段必须能够转换为布尔值。接受的输入是 true、false、1、0、"1" 和 "0"
     */
    public function vBoolean(bool $enable = true): self
    {
        if ($enable) $this->rule->add('boolean');
        return $this;
    }

    /**
     * Confirmed
     * The field under validation must have a matching field of foo_confirmation. For example, if the field under validation is password, a matching password_confirmation field must be present in the input.
     * 待验证字段必须有一个与 foo_confirmation 匹配的字段。例如，如果待验证字段是 password，则输入中必须存在一个匹配的 password_confirmation 字段
     */
    public function vConfirmed(bool $enable = true): self
    {
        if ($enable) $this->rule->add('confirmed');
        return $this;
    }

    /**
     * Contains
     * The field under validation must contain the given value. The field may be an array, string, or file.
     * 待验证字段必须包含给定值。字段可以是数组、字符串或文件
     */
    public function vContains(string $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('contains:' . $value);
        return $this;
    }

    /**
     * Current Password
     * The field under validation must match the authenticated user's password. You may specify an attribute to use for the user's password.
     * 待验证字段必须与经过身份验证的用户的密码匹配。您可以指定一个属性用于用户的密码
     */
    public function vCurrentPassword(string $attribute = 'password', bool $enable = true): self
    {
        if ($enable) $this->rule->add('current_password:' . $attribute);
        return $this;
    }

    /**
     * Date
     * The field under validation must be a valid date according to the strtotime PHP function.
     * 待验证字段必须是根据 strtotime PHP 函数有效的日期
     */
    public function vDate(bool $enable = true): self
    {
        if ($enable) $this->rule->add('date');
        return $this;
    }

    /**
     * Date Equals
     * The field under validation must be equal to the given date. The dates will be passed into the PHP strtotime function.
     * 待验证字段必须等于给定日期。日期将传递到 PHP strtotime 函数
     */
    public function vDateEquals(string $date, bool $enable = true): self
    {
        if ($enable) $this->rule->add('date_equals:' . $date);
        return $this;
    }

    /**
     * Date Format
     * The field under validation must match the given format. You should use either date or date_format when validating a field, not both.
     * 待验证字段必须匹配给定的格式。在验证字段时，您应该使用 date 或 date_format，而不是两者都使用
     */
    public function vDateFormat(string $format, bool $enable = true): self
    {
        if ($enable) $this->rule->add('date_format:' . $format);
        return $this;
    }

    /**
     * Decimal
     * The field under validation must be a decimal.
     * 待验证字段必须是十进制数
     */
    public function vDecimal(bool $enable = true): self
    {
        if ($enable) $this->rule->add('decimal');
        return $this;
    }

    /**
     * Declined
     * The field under validation must be "no", "off", "false", or "0". This is useful for validating "Terms of Service" rejection or similar fields.
     * 待验证字段必须是 「no」 ，「off」 ，「false」 或 0。这对于验证「服务条款」的拒绝或类似字段时很有用
     */
    public function vDeclined(bool $enable = true): self
    {
        if ($enable) $this->rule->add('declined');
        return $this;
    }

    /**
     * Declined If
     * The field under validation must be declined if another field is equal to a given value.
     * 如果另一个字段等于给定值，则必须拒绝验证字段
     */
    public function vDeclinedIf(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('declined_if:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Different
     * The field under validation must have a different value than field.
     * 待验证字段的值必须与字段不同
     */
    public function vDifferent(string $field, bool $enable = true): self
    {
        if ($enable) $this->rule->add('different:' . $field);
        return $this;
    }

    /**
     * Digits
     * The field under validation must be numeric and must have an exact length of value.
     * 待验证字段必须是数字，并且必须具有值的确切长度
     */
    public function vDigits(int $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('digits:' . $value);
        return $this;
    }

    /**
     * Digits Between
     * The field under validation must have a length between the given min and max.
     * 待验证字段的长度必须在给定的最小值和最大值之间
     */
    public function vDigitsBetween(int $min, int $max, bool $enable = true): self
    {
        if ($enable) $this->rule->add('digits_between:' . $min . ',' . $max);
        return $this;
    }

    /**
     * Dimensions (Image Files)
     * The file under validation must be an image meeting the dimension constraints as specified by the rule's parameters.
     * 待验证文件必须是符合规则参数指定的尺寸约束的图像
     */
    public function vDimensions(array $parameters, bool $enable = true): self
    {
        if ($enable) $this->rule->add('dimensions:' . implode(',', $parameters));
        return $this;
    }

    /**
     * Distinct
     * When working with arrays, the field under validation must not have any duplicate values.
     * 在处理数组时，待验证字段不能有任何重复值
     */
    public function vDistinct(bool $enable = true): self
    {
        if ($enable) $this->rule->add('distinct');
        return $this;
    }

    /**
     * Doesnt Start With
     * The field under validation must not start with one of the given values.
     * 待验证字段不能以给定值之一开头
     */
    public function vDoesntStartWith(string $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('doesnt_start_with:' . $value);
        return $this;
    }

    /**
     * Doesnt End With
     * The field under validation must not end with one of the given values.
     * 待验证字段不能以给定值之一结尾
     */
    public function vDoesntEndWith(string $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('doesnt_end_with:' . $value);
        return $this;
    }

    /**
     * Email
     * The field under validation must be formatted as an e-mail address.
     * 待验证字段必须格式化为电子邮件地址
     */
    public function vEmail(bool $enable = true): self
    {
        if ($enable) $this->rule->add('email');
        return $this;
    }

    /**
     * Ends With
     * The field under validation must end with one of the given values.
     * 待验证字段必须以给定值之一结尾
     */
    public function vEndsWith(string $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('ends_with:' . $value);
        return $this;
    }

    /**
     * Enum
     * The field under validation must be included in the given list of values.
     * 待验证字段必须包含在给定的值列表中
     */
    public function vEnum(array $values, bool $enable = true): self
    {
        if ($enable) $this->rule->add('enum:' . implode(',', $values));
        return $this;
    }

    /**
     * Exclude
     * The field under validation must not be included in the given list of values.
     * 待验证字段不能包含在给定的值列表中
     */
    public function vExclude(array $values, bool $enable = true): self
    {
        if ($enable) $this->rule->add('exclude:' . implode(',', $values));
        return $this;
    }

    /**
     * Exclude If
     * The field under validation must not be included in the given list of values if another field is equal to a given value.
     * 如果另一个字段等于给定值，则待验证字段不能包含在给定的值列表中
     */
    public function vExcludeIf(string $field, $value, array $values, bool $enable = true): self
    {
        if ($enable) $this->rule->add('exclude_if:' . $field . ',' . $value . ',' . implode(',', $values));
        return $this;
    }

    /**
     * Exclude Unless
     * The field under validation must not be included in the given list of values unless another field is equal to a given value.
     * 除非另一个字段等于给定值，否则待验证字段不能包含在给定的值列表中
     */
    public function vExcludeUnless(string $field, $value, array $values, bool $enable = true): self
    {
        if ($enable) $this->rule->add('exclude_unless:' . $field . ',' . $value . ',' . implode(',', $values));
        return $this;
    }

    /**
     * Exclude With
     * The field under validation must not be included in the given list of values if another field is equal to a given value.
     * 如果另一个字段等于给定值，则待验证字段不能包含在给定的值列表中
     */
    public function vExcludeWith(string $field, $value, array $values, bool $enable = true): self
    {
        if ($enable) $this->rule->add('exclude_with:' . $field . ',' . $value . ',' . implode(',', $values));
        return $this;
    }

    /**
     * Exclude Without
     * The field under validation must not be included in the given list of values if another field is not equal to a given value.
     * 如果另一个字段不等于给定值，则待验证字段不能包含在给定的值列表中
     */
    public function vExcludeWithout(string $field, $value, array $values, bool $enable = true): self
    {
        if ($enable) $this->rule->add('exclude_without:' . $field . ',' . $value . ',' . implode(',', $values));
        return $this;
    }

    /**
     * Exists (Database)
     * The field under validation must exist on a given database table.
     * 待验证字段必须存在于给定的数据库表中
     */
    public function vExists(string $table, string $column = null, bool $enable = true): self
    {
        if ($enable) $this->rule->add('exists:' . $table . ($column ? ',' . $column : ''));
        return $this;
    }

    /**
     * Extensions
     * The file under validation must have one of the given extensions.
     * 待验证文件必须具有给定的扩展名之一
     */
    public function vExtensions(array $extensions, bool $enable = true): self
    {
        if ($enable) $this->rule->add('extensions:' . implode(',', $extensions));
        return $this;
    }

    /**
     * File
     * The field under validation must be a successfully uploaded file.
     * 待验证字段必须是成功上传的文件
     */
    public function vFile(bool $enable = true): self
    {
        if ($enable) $this->rule->add('file');
        return $this;
    }

    /**
     * Filled
     * The field under validation must not be empty when it is present.
     * 当字段存在时，待验证字段不能为空
     */
    public function vFilled(bool $enable = true): self
    {
        if ($enable) $this->rule->add('filled');
        return $this;
    }

    /**
     * Greater Than
     * The field under validation must be greater than the given field. The two fields must be of the same type. Strings, numerics, arrays, and files are evaluated using the same conventions as the size rule.
     * 待验证字段必须大于给定字段。两个字段必须是相同类型。字符串、数字、数组和文件的评估方式与 size 规则相同
     */
    public function vGreaterThan(string $field, bool $enable = true): self
    {
        if ($enable) $this->rule->add('gt:' . $field);
        return $this;
    }

    /**
     * Greater Than Or Equal
     * The field under validation must be greater than or equal to the given field. The two fields must be of the same type. Strings, numerics, arrays, and files are evaluated using the same conventions as the size rule.
     * 待验证字段必须大于或等于给定字段。两个字段必须是相同类型。字符串、数字、数组和文件的评估方式与 size 规则相同
     */
    public function vGreaterThanOrEqual(string $field, bool $enable = true): self
    {
        if ($enable) $this->rule->add('gte:' . $field);
        return $this;
    }

    /**
     * Hex Color
     * The field under validation must be a valid hexadecimal color.
     * 待验证字段必须是有效的十六进制颜色
     */
    public function vHexColor(bool $enable = true): self
    {
        if ($enable) $this->rule->add('hex_color');
        return $this;
    }

    /**
     * Image (File)
     * The file under validation must be an image (jpeg, png, bmp, gif, or svg).
     * 待验证文件必须是图像（jpeg、png、bmp、gif 或 svg）
     */
    public function vImage(bool $enable = true): self
    {
        if ($enable) $this->rule->add('image');
        return $this;
    }

    /**
     * In
     * The field under validation must be included in the given list of values.
     * 待验证字段必须包含在给定的值列表中
     */
    public function vIn(array $values, bool $enable = true): self
    {
        if ($enable) $this->rule->add('in:' . implode(',', $values));
        return $this;
    }

    /**
     * In Array
     * The field under validation must be present in the input data but can be empty.
     * 待验证字段必须存在于输入数据中，但可以为空
     */
    public function vInArray(bool $enable = true): self
    {
        if ($enable) $this->rule->add('in_array');
        return $this;
    }

    /**
     * Integer
     * The field under validation must be an integer.
     * 待验证字段必须是整数
     */
    public function vInteger(bool $enable = true): self
    {
        if ($enable) $this->rule->add('integer');
        return $this;
    }

    /**
     * IP Address
     * The field under validation must be an IP address.
     * 待验证字段必须是 IP 地址
     */
    public function vIpAddress(bool $enable = true): self
    {
        if ($enable) $this->rule->add('ip');
        return $this;
    }

    /**
     * JSON
     * The field under validation must be a valid JSON string.
     * 待验证字段必须是有效的 JSON 字符串
     */
    public function vJson(bool $enable = true): self
    {
        if ($enable) $this->rule->add('json');
        return $this;
    }

    /**
     * Less Than
     * The field under validation must be less than the given field. The two fields must be of the same type. Strings, numerics, arrays, and files are evaluated using the same conventions as the size rule.
     * 待验证字段必须小于给定字段。两个字段必须是相同类型。字符串、数字、数组和文件的评估方式与 size 规则相同
     */
    public function vLessThan(string $field, bool $enable = true): self
    {
        if ($enable) $this->rule->add('lt:' . $field);
        return $this;
    }

    /**
     * Less Than Or Equal
     * The field under validation must be less than or equal to the given field. The two fields must be of the same type. Strings, numerics, arrays, and files are evaluated using the same conventions as the size rule.
     * 待验证字段必须小于或等于给定字段。两个字段必须是相同类型。字符串、数字、数组和文件的评估方式与 size 规则相同
     */
    public function vLessThanOrEqual(string $field, bool $enable = true): self
    {
        if ($enable) $this->rule->add('lte:' . $field);
        return $this;
    }

    /**
     * List
     * The field under validation must be a list of comma- or pipe-separated values.
     * 待验证字段必须是逗号或管道分隔的值列表
     */
    public function vList(bool $enable = true): self
    {
        if ($enable) $this->rule->add('list');
        return $this;
    }

    /**
     * Lowercase
     * The field under validation must be entirely lowercase.
     * 待验证字段必须完全是小写
     */
    public function vLowercase(bool $enable = true): self
    {
        if ($enable) $this->rule->add('lowercase');
        return $this;
    }

    /**
     * MAC Address
     * The field under validation must be a valid MAC address.
     * 待验证字段必须是有效的 MAC 地址
     */
    public function vMacAddress(bool $enable = true): self
    {
        if ($enable) $this->rule->add('mac_address');
        return $this;
    }

    /**
     * Max
     * The field under validation must be less than or equal to a maximum value. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
     * 待验证字段必须小于或等于最大值。字符串、数字、数组和文件的评估方式与 size 规则相同
     */
    public function vMax(int $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('max:' . $value);
        return $this;
    }

    /**
     * Max Digits
     * The field under validation must have a length less than or equal to the given value.
     * 待验证字段的长度必须小于或等于给定值
     */
    public function vMaxDigits(int $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('max_digits:' . $value);
        return $this;
    }

    /**
     * MIME Types
     * The file under validation must match one of the given MIME types.
     * 待验证文件必须匹配给定的 MIME 类型之一
     */
    public function vMimeTypes(array $types, bool $enable = true): self
    {
        if ($enable) $this->rule->add('mimes:' . implode(',', $types));
        return $this;
    }

    /**
     * MIME Type By File Extension
     * The file under validation must have a MIME type corresponding to one of the file extensions.
     * 待验证文件必须具有与文件扩展名对应的 MIME 类型
     */
    public function vMimeTypeByFileExtension(bool $enable = true): self
    {
        if ($enable) $this->rule->add('mimetypes');
        return $this;
    }

    /**
     * Min
     * The field under validation must have a minimum value. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
     * 待验证字段必须具有最小值。字符串、数字、数组和文件的评估方式与 size 规则相同
     */
    public function vMin(int $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('min:' . $value);
        return $this;
    }

    /**
     * Min Digits
     * The field under validation must have a length greater than or equal to the given value.
     * 待验证字段的长度必须大于或等于给定值
     */
    public function vMinDigits(int $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('min_digits:' . $value);
        return $this;
    }

    /**
     * Missing
     * The field under validation must be missing from the input data.
     * 待验证字段必须在输入数据中缺失
     */
    public function vMissing(bool $enable = true): self
    {
        if ($enable) $this->rule->add('missing');
        return $this;
    }

    /**
     * Missing If
     * The field under validation must be missing from the input data if another field is equal to a given value.
     * 如果另一个字段等于给定值，则待验证字段必须在输入数据中缺失
     */
    public function vMissingIf(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('missing_if:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Missing Unless
     * The field under validation must be missing from the input data unless another field is equal to a given value.
     * 除非另一个字段等于给定值，否则待验证字段必须在输入数据中缺失
     */
    public function vMissingUnless(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('missing_unless:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Missing With
     * The field under validation must be missing from the input data when any of the other specified fields are present.
     * 当其他指定字段中的任何一个存在时，待验证字段必须在输入数据中缺失
     */
    public function vMissingWith(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('missing_with:' . implode(',', $fields));
        return $this;
    }

    /**
     * Missing With All
     * The field under validation must be missing from the input data when all of the other specified fields are present.
     * 当所有其他指定字段都存在时，待验证字段必须在输入数据中缺失
     */
    public function vMissingWithAll(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('missing_with_all:' . implode(',', $fields));
        return $this;
    }

    /**
     * Multiple Of
     * The field under validation must be a value that is a multiple of value.
     * 待验证字段必须是 value 的倍数
     */
    public function vMultipleOf(int $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('multiple_of:' . $value);
        return $this;
    }

    /**
     * Not In
     * The field under validation must not be included in the given list of values.
     * 待验证字段不能包含在给定的值列表中
     */
    public function vNotIn(array $values, bool $enable = true): self
    {
        if ($enable) $this->rule->add('not_in:' . implode(',', $values));
        return $this;
    }

    /**
     * Not Regex
     * The field under validation must not match the given regular expression.
     * 待验证字段不能匹配给定的正则表达式
     */
    public function vNotRegex(string $pattern, bool $enable = true): self
    {
        if ($enable) $this->rule->add('not_regex:' . $pattern);
        return $this;
    }

    /**
     * Nullable
     * The field under validation may be null. This is particularly useful when validating primitive such as strings and integers.
     * 待验证字段可以为 null。在验证原始类型（如字符串和整数）时特别有用
     */
    public function vNullable(bool $enable = true): self
    {
        if ($enable) $this->rule->add('nullable');
        return $this;
    }

    /**
     * Numeric
     * The field under validation must be numeric.
     * 待验证字段必须是数字
     */
    public function vNumeric(bool $enable = true): self
    {
        if ($enable) $this->rule->add('numeric');
        return $this;
    }

    /**
     * Present
     * The field under validation must be present in the input data but can be empty.
     * 待验证字段必须存在于输入数据中，但可以为空
     */
    public function vPresent(bool $enable = true): self
    {
        if ($enable) $this->rule->add('present');
        return $this;
    }

    /**
     * Present If
     * The field under validation must be present and not empty if the another field is equal to a given value.
     * 如果另一个字段等于给定值，则待验证字段必须存在且不为空
     */
    public function vPresentIf(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('present_if:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Present Unless
     * The field under validation must be present and not empty unless the another field is equal to a given value.
     * 除非另一个字段等于给定值，否则待验证字段必须存在且不为空
     */
    public function vPresentUnless(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('present_unless:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Present With
     * The field under validation must be present and not empty only if any of the other specified fields are present.
     * 只有在其他指定字段中有任何一个存在时，待验证字段才必须存在且不为空
     */
    public function vPresentWith(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('present_with:' . implode(',', $fields));
        return $this;
    }

    /**
     * Present With All
     * The field under validation must be present and not empty only if all of the other specified fields are present.
     * 只有在所有其他指定字段都存在时，待验证字段才必须存在且不为空
     */
    public function vPresentWithAll(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('present_with_all:' . implode(',', $fields));
        return $this;
    }

    /**
     * Regular Expression
     * The field under validation must match the given regular expression.
     * 待验证字段必须匹配给定的正则表达式
     */
    public function vRegex(string $pattern, bool $enable = true): self
    {
        if ($enable) $this->rule->add('regex:' . $pattern);
        return $this;
    }

    /**
     * Required
     * The field under validation must be present in the input data and not empty. A field is considered "empty" if one of the following conditions are true:
     * 待验证字段必须存在于输入数据中且不为空。如果满足以下条件之一，则字段被视为空：
     * 1. The value is null.
     * 2. The value is an empty string.
     * 3. The value is an empty array or empty Countable object.
     * 4. The value is an uploaded file with no path.
     */
    public function vRequired(bool $enable = true): self
    {
        if ($enable) $this->rule->add('required');
        return $this;
    }

    /**
     * Required If
     * The field under validation must be present and not empty if the another field is equal to a given value.
     * 如果另一个字段等于给定值，则待验证字段必须存在且不为空
     */
    public function vRequiredIf(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('required_if:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Required Unless
     * The field under validation must be present and not empty unless the another field is equal to a given value.
     * 除非另一个字段等于给定值，否则待验证字段必须存在且不为空
     */
    public function vRequiredUnless(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('required_unless:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Required With
     * The field under validation must be present and not empty only if any of the other specified fields are present.
     * 只有在其他指定字段中有任何一个存在时，待验证字段才必须存在且不为空
     */
    public function vRequiredWith(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('required_with:' . implode(',', $fields));
        return $this;
    }

    /**
     * Required With All
     * The field under validation must be present and not empty only if all of the other specified fields are present.
     * 只有在所有其他指定字段都存在时，待验证字段才必须存在且不为空
     */
    public function vRequiredWithAll(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('required_with_all:' . implode(',', $fields));
        return $this;
    }

    /**
     * Required Without
     * The field under validation must be present and not empty only when any of the other specified fields are not present.
     * 只有在其他指定字段中有任何一个不存在时，待验证字段才必须存在且不为空
     */
    public function vRequiredWithout(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('required_without:' . implode(',', $fields));
        return $this;
    }

    /**
     * Required Without All
     * The field under validation must be present and not empty only when all of the other specified fields are not present.
     * 只有在所有其他指定字段都不存在时，待验证字段才必须存在且不为空
     */
    public function vRequiredWithoutAll(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('required_without_all:' . implode(',', $fields));
        return $this;
    }

    /**
     * Same
     * The given field must match the field under validation.
     * 给定字段必须与待验证字段匹配
     */
    public function vSame(string $field, bool $enable = true): self
    {
        if ($enable) $this->rule->add('same:' . $field);
        return $this;
    }

    /**
     * Size
     * The field under validation must have a size matching the given value. For string data, value corresponds to the number of characters. For numeric data, value corresponds to a given integer value. For an array, size corresponds to the count of the array. For files, size corresponds to the file size in kilobytes.
     * 待验证字段的大小必须与给定值匹配。对于字符串数据，value 对应于字符数。对于数字数据，value 对应于给定的整数值。对于数组，size 对应于数组的计数。对于文件，size 对应于以千字节为单位的文件大小
     */
    public function vSize(int $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('size:' . $value);
        return $this;
    }

    /**
     * Starts With
     * The field under validation must start with one of the given values.
     * 待验证字段必须以给定值之一开头
     */
    public function vStartsWith(string $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('starts_with:' . $value);
        return $this;
    }

    /**
     * String
     * The field under validation must be a string.
     * 待验证字段必须是字符串
     */
    public function vString(bool $enable = true): self
    {
        if ($enable) $this->rule->add('string');
        return $this;
    }

    /**
     * Timezone
     * The field under validation must be a valid timezone identifier according to the timezone_identifiers_list PHP function.
     * 待验证字段必须是根据 timezone_identifiers_list PHP 函数有效的时区标识符
     */
    public function vTimezone(bool $enable = true): self
    {
        if ($enable) $this->rule->add('timezone');
        return $this;
    }

    /**
     * Unique (Database)
     * The field under validation must be unique on a given database table. If the column option is not specified, the field name will be used.
     * 待验证字段必须在给定的数据库表上是唯一的。如果未指定 column 选项，则将使用字段名
     */
    public function vUnique(string $table, string $column = null, bool $enable = true): self
    {
        if ($enable) $this->rule->add('unique:' . $table . ($column ? ',' . $column : ''));
        return $this;
    }

    /**
     * URL
     * The field under validation must be a valid URL.
     * 待验证字段必须是有效的 URL
     */
    public function vUrl(bool $enable = true): self
    {
        if ($enable) $this->rule->add('url');
        return $this;
    }

    /**
     * Uppercase
     * The field under validation must be entirely uppercase.
     * 待验证字段必须完全是大写
     */
    public function vUppercase(bool $enable = true): self
    {
        if ($enable) $this->rule->add('uppercase');
        return $this;
    }

    /**
     * UUID
     * The field under validation must be a valid RFC 4122 (version 1, 3, 4, or 5) universally unique identifier (UUID).
     * 待验证字段必须是有效的 RFC 4122（版本 1、3、4 或 5）通用唯一标识符（UUID）
     */
    public function vUuid(bool $enable = true): self
    {
        if ($enable) $this->rule->add('uuid');
        return $this;
    }

    /**
     * Validate If
     * The field under validation must be present and not empty if the another field is equal to a given value.
     * 如果另一个字段等于给定值，则待验证字段必须存在且不为空
     */
    public function vValidateIf(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('validate_if:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Validate Unless
     * The field under validation must be present and not empty unless the another field is equal to a given value.
     * 除非另一个字段等于给定值，否则待验证字段必须存在且不为空
     */
    public function vValidateUnless(string $field, $value, bool $enable = true): self
    {
        if ($enable) $this->rule->add('validate_unless:' . $field . ',' . $value);
        return $this;
    }

    /**
     * Validate With
     * The field under validation must be present and not empty only if any of the other specified fields are present.
     * 只有在其他指定字段中有任何一个存在时，待验证字段才必须存在且不为空
     */
    public function vValidateWith(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('validate_with:' . implode(',', $fields));
        return $this;
    }

    /**
     * Validate With All
     * The field under validation must be present and not empty only if all of the other specified fields are present.
     * 只有在所有其他指定字段都存在时，待验证字段才必须存在且不为空
     */
    public function vValidateWithAll(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('validate_with_all:' . implode(',', $fields));
        return $this;
    }

    /**
     * Validate Without
     * The field under validation must be present and not empty only when any of the other specified fields are not present.
     * 只有在其他指定字段中有任何一个不存在时，待验证字段才必须存在且不为空
     */
    public function vValidateWithout(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('validate_without:' . implode(',', $fields));
        return $this;
    }

    /**
     * Validate Without All
     * The field under validation must be present and not empty only when all of the other specified fields are not present.
     * 只有在所有其他指定字段都不存在时，待验证字段才必须存在且不为空
     */
    public function vValidateWithoutAll(array $fields, bool $enable = true): self
    {
        if ($enable) $this->rule->add('validate_without_all:' . implode(',', $fields));
        return $this;
    }
}
