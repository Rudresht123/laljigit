
@php
            // Fetch the email template
    $template = DB::table('email_templates')->where('slug', 'reset_password')->first();
      // Ensure the table name is correct
    $contactTemplate = $template ? $template->content : 'Email template not found.';


    $data=[
        'name'=>$template->name,
        'from_name'=>$template->from_name,
        'url'=>$url
    ];

if($contactTemplate){
    foreach ($data as $key => $value) {
    $contactTemplate = str_replace("{" . $key . "}", $value, $contactTemplate);
}
}
else {
            $contactTemplate = 'User data not found.';
        }
@endphp




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$template->name}}</title>
</head>
<body>
{!! $contactTemplate !!}
</body>