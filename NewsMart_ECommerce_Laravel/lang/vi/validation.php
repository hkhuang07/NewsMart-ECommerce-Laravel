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
	'accepted' => 'Trường này phải được chấp nhận.',
	'accepted_if' => 'Trường này phải được chấp nhận.',
	'active_url' => 'Trường này không phải là một đường dẫn URL.',
	'after' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu.',
	'after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',
	'alpha' => 'Trường này chỉ có thể chứa các chữ cái.',
	'alpha_dash' => 'Trường này chỉ có thể chứa các chữ cái, số và dấu gạch ngang.',
	'alpha_num' => 'Trường này chỉ có thể chứa các chữ cái và số.',
	'any_of' => 'Trường này không hợp lệ.',
	'array' => 'Trường này phải là một danh sách.',
	'ascii' => 'Trường này chỉ chấp nhận các ký tự ASCII.',
	'before' => 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc.',
	'before_or_equal' => 'Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.',
	'between' => [
		'array' => 'Trường này phải có từ :min đến :max mục.',
		'file' => 'Dung lượng phải từ :min đến :max KB.',
		'numeric' => 'Giá trị phải trong khoảng :min và :max.',
		'string' => 'Giá trị phải từ :min đến :max ký tự.',
	],
	'boolean' => 'Trường này phải là true hoặc false.',
	'can' => 'Trường này có chứa giá trị không được chấp nhận.',
	'confirmed' => 'Trường mật khẩu xác nhận không khớp.',
	'contains' => 'Trường này thiếu giá trị bắt buộc.',
	'current_password' => 'Mật khẩu không đúng.',
	'date' => 'Trường này không phải là một ngày hợp lệ.',
	'date_equals' => 'Trường này phải là kiểu ngày và có giá trị bằng :date.',
	'date_format' => 'Trường này không phù hợp với định dạng :format.',
	'decimal' => 'Trường này phải có :decimal chữ số thập phân.',
	'declined' => 'Trường này phải bị từ chối.',
	'declined_if' => 'Trường này phải bị từ chối khi giá trị của :other là :value.',
	'different' => 'Trường :attribute và :other phải khác nhau.',
	'digits' => 'Trường này phải chứa :digits ký tự số.',
	'digits_between' => 'Trường này phải chứa từ :min đến :max ký số.',
	'dimensions' => 'Kích thước hình ảnh không phù hợp.',
	'distinct' => 'Trường này có một giá trị trùng lặp.',
	'doesnt_contain' => 'Trường này không được chứa bất kỳ giá trị nào sau đây: :values.',
	'doesnt_end_with' => 'Trường này không được kết thúc bằng một trong các giá trị sau: :values.',
	'doesnt_start_with' => 'Trường này không được bắt đầu bằng một trong các giá trị sau: :values.',
	'email' => 'Trường này phải là một địa chỉ email hợp lệ.',
	'ends_with' => 'Trường này phải kết thúc bằng: :values',
	'enum' => 'Trường được chọn không hợp lệ.',
	'exists' => 'Trường được chọn không hợp lệ.',
	'extensions' => 'Chỉ chấp nhận tập tin có phần mở rộng: :values.',
	'file' => 'Trường này phải là một tập tin.',
	'filled' => 'Trường này bắt buộc phải nhập.',
	'gt' => [
		'array' => 'Trường này phải chứa nhiều hơn :value mục.',
		'file' => 'Dung lượng phải lớn hơn :value KB.',
		'numeric' => 'Giá trị phải lớn hơn :value.',
		'string' => 'Trường này phải nhiều hơn :value ký tự.',
	],
	'gte' => [
		'array' => 'Trường này phải chứa nhiều hơn hoặc bằng :value mục.',
		'file' => 'Dung lượng phải lớn hơn hoặc bằng :value KB.',
		'numeric' => 'Giá trị phải lớn hơn hoặc bằng :value.',
		'string' => 'Trường này phải nhiều hơn hoặc bằng :value ký tự.',
	],
	'hex_color' => 'Trường này phải là một mã màu thập lục phân (hex) hợp lệ.',
	'image' => 'Trường này phải là một hình ảnh.',
	'in' => 'Trường được chọn không hợp lệ.',
	'in_array' => 'Trường này không tồn tại trong :other.',
	'in_array_keys' => 'Trường này phải chứa ít nhất một trong các khóa sau: :values.',
	'integer' => 'Trường này phải là số nguyên.',
	'ip' => 'Trường này phải là một địa chỉ IP hợp lệ.',
	'ipv4' => 'Trường này phải là một địa chỉ IPv4 hợp lệ.',
	'ipv6' => 'Trường này phải là một địa chỉ IPv6 hợp lệ.',
	'json' => 'Trường này phải là một chuỗi JSON hợp lệ.',
	'list' => 'Trường này phải là một danh sách.',
	'lowercase' => 'Trường này phải là chữ thường.',
	'lt' => [
		'array' => 'Trường này phải chứa ít hơn :value mục.',
		'file' => 'Dung lượng phải nhỏ hơn :value KB.',
		'numeric' => 'Giá trị phải nhỏ hơn :value.',
		'string' => 'Trường này phải ít hơn :value ký tự.',
	],
	'lte' => [
		'array' => 'Trường này phải chứa ít hơn hoặc bằng :value mục.',
		'file' => 'Dung lượng phải nhỏ hơn hoặc bằng :value KB.',
		'numeric' => 'Giá trị phải nhỏ hơn hoặc bằng :value.',
		'string' => 'Trường này phải ít hơn hoặc bằng :value ký tự.',
	],
	'mac_address' => 'Trường này phải là một địa chỉ MAC hợp lệ.',
	'max' => [
		'array' => 'Trường này không được có quá :max mục.',
		'file' => 'Dung lượng không được vượt quá :max KB.',
		'numeric' => 'Giá trị không được lớn hơn :max.',
		'string' => 'Trường này không được vượt quá :max ký tự.',
	],
	'max_digits' => 'Trường này không được có nhiều hơn :max chữ số.',
	'mimes' => 'Trường này phải là một tập tin kiểu: :values.',
	'mimetypes' => 'Trường này phải là một tập tin kiểu: :values.',
	'min' => [
		'array' => 'Trường này phải có ít nhất :min mục.',
		'file' => 'Tập tin phải có dung lượng tối thiểu :min KB.',
		'numeric' => 'Giá trị trường này phải tối thiểu là :min.',
		'string' => 'Trường này phải có ít nhất :min ký tự.',
	],
	'min_digits' => 'Trường này phải có ít nhất :min chữ số.',
	'missing' => 'Trường này không được tồn tại.',
	'missing_if' => 'Trường này không được tồn tại khi giá trị của :other là :value.',
	'missing_unless' => 'Trường này không được tồn tại trừ khi giá trị của :other là :value.',
	'missing_with' => 'Trường này không được tồn tại khi có mặt :values.',
	'missing_with_all' => 'Trường này không được tồn tại khi có mặt :values.',
	'multiple_of' => 'Trường này phải là bội số của :value.',
	'not_in' => 'Trường được chọn không hợp lệ.',
	'not_regex' => 'Trường này sai định dạng.',
	'numeric' => 'Trường này phải là một số.',
	'password' => [
		'letters' => 'Trường này phải chứa ít nhất một ký tự chữ cái.',
		'mixed' => 'Trường này phải chứa ít nhất một ký tự hoa và một ký tự thường.',
		'numbers' => 'Trường này phải chứa ít nhất một chữ số.',
		'symbols' => 'Trường này phải chứa ít nhất một ký tự đặc biệt.',
		'uncompromised' => 'Mật khẩu vừa nhập đã xuất hiện trong một vụ rò rỉ dữ liệu. Vui lòng chọn một mật khẩu khác.',
	],
	'present' => 'Trường này phải tồn tại.',
	'present_if' => 'Trường này phải tồn tại khi giá trị của :other là :value.',
	'present_unless' => 'Trường này phải tồn tại trừ khi giá trị của :other là :value.',
	'present_with' => 'Trường này phải tồn tại khi có mặt :values.',
	'present_with_all' => 'Trường này phải tồn tại khi có mặt :values.',
	'prohibited' => 'Trường này không được tồn tại.',
	'prohibited_if' => 'Trường này không được tồn tại khi giá trị của :other là :value.',
	'prohibited_if_accepted' => 'Trường này bị cấm khi trường :other được chấp nhận.',
    'prohibited_if_declined' => 'Trường này bị cấm khi trường :other bị từ chối.',
	'prohibited_unless' => 'Trường này không được tồn tại trừ khi giá trị của :other là :value.',
	'prohibits' => 'Trường này cấm :other hiện diện.',
	'regex' => 'Trường này sai định dạng.',
	'required' => 'Trường này bắt buộc phải nhập.',
	'required_array_keys' => 'Trường này phải chứa các mục cho: :values.',
	'required_if' => 'Trường này bắt buộc nhập khi :other là :value.',
	'required_if_accepted' => 'Trường này là bắt buộc khi :other được chấp nhận.',
	'required_if_declined' => 'Trường này là bắt buộc khi :other bị từ chối.',
	'required_unless' => 'Trường này bắt buộc nhập trừ khi :other là :values.',
	'required_with' => 'Trường này bắt buộc nhập khi tồn tại :values.',
	'required_with_all' => 'Trường này bắt buộc nhập khi tồn tại :values.',
	'required_without' => 'Phải nhập dữ liệu vào một trong số các trường này.',
	'required_without_all' => 'Trường này bắt buộc nhập khi không tồn tại :values.',
	'same' => 'Trường :attribute và :other phải có giá trị trùng khớp.',
	'size' => [
		'array' => 'Trường này phải chứa :size mục.',
		'file' => 'Tập tin phải có dung lượng bằng :size KB.',
		'numeric' => 'Trường này phải có giá trị bằng :size.',
		'string' => 'Trường này phải chứa :size ký tự.',
	],
	'starts_with' => 'Trường này phải bắt đầu bằng: :values',
	'string' => 'Trường này phải là một chuỗi.',
	'timezone' => 'Trường này phải là múi giờ hợp lệ.',
	'unique' => 'Thông tin đã tồn tại trong hệ thống.',
	'uploaded' => 'Không thể upload tập tin.',
	'uppercase' => 'Trường này phải là chữ in hoa.',
	'url' => 'Trường này phải là một đường dẫn hợp lệ.',
	'ulid' => 'Trường này phải là một ULID hợp lệ.',
	'uuid' => 'Trường này phải là một UUID hợp lệ.',
	
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