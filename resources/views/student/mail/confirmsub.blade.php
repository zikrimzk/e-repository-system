<?php
use Carbon\Carbon;
use App\Models\Activity;
?>
<x-mail::message>
<p>Assalamualaikum and Good Day.</p>
<p>Dear Lecturer,</p>
<p>We hope you're doing well.</p>
<p>{{ auth()->user()->name }} have confirmed their <b>{{ Activity::where('id',$data['activity_id'])->first()->act_name }}</b> on {{ Carbon::parse($data['ac_dateStudent'])->format('d M Y h:i:s A') }} through the system.  </p>
Click <a href="{{ route('staff.login') }}">here</a> to log in to the system.
    
Thank you.
    
Regards,<br>
FTMK PG e-Repository
</x-mail::message>
