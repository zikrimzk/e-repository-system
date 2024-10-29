<?php
use Carbon\Carbon;
?>
<x-mail::message>
<p>Assalamualaikum and Good Day.</p>
<p>Dear {{ $data['name'] }},</p>
<p>We hope you're doing well.</p>
<p>Please submit your <b>{{ $data['actname'] }}</b> - {{ $data['docname'] }} documents before {{ Carbon::parse($data['duedate'])->format('d M Y h:i:s A') }} through the system.  </p>

Click <a href="{{ route('student.login') }}">here</a> to log in to the system.

Thank you.

Regards,<br>
FTMK Postgraduate Committee
</x-mail::message>
