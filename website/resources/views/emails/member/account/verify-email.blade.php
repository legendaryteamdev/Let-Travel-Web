@extends('emails.layout.master')
 @section ('content')
 <tbody>
    <tr>
        <td style="font-size:0;padding:30px 30px 18px;" align="left">
            <div class="mj-content" style="cursor:auto;color:#000000;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:24px;line-height:22px;">ការផ្ទៀងផ្ទាត់តាមរយៈអីុម៉ែល</div>
        </td>
    </tr>
    <tr>
        <td style="font-size:0;padding:0 30px 16px;" align="left">
            <div class="mj-content" style="cursor:auto;color:#000000;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;">ជូនចំពោះ <b>{{$data['name']}}</b></div>
        </td>
    </tr>
   
    <tr>
        <td style="font-size:0;padding:0 30px 16px;" align="left">
            <div class="mj-content" style="cursor:auto;color:#000000;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;">
              <p>
                សូមប្រើប្រាស់កូដនេះ <b>{{ $data['code'] }}</b> ដើម្បើធ្វើការផ្ទៀងផ្ទាត់ ឬ ចុចតំណរខាងក្រោម <br />
                <a class="mj-content" href="{{ env('MEMBER_URL',null) }}#/auth/verify-email?code={{ $data['code'] }}" style="display:inline-block;text-decoration:none;background:#00a8ff;border:1px solid #00a8ff;border-radius:25px;color:white;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:15px;font-weight:400;padding:8px 16px 10px;" target="_blank">ផ្ទៀងផ្ទាត់</a>
              </p>
             
          </div>
        </td>
    </tr>
     <tr>
        <td style="font-size:0;padding:0 30px 16px;" align="left">
            <div class="mj-content" style="cursor:auto;color:#000000;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;">សូមគោរព, <br /> <b>ក្រសួងសាធារណការ និងដឹកជញ្ជូន</b></div>
        </td>
    </tr>
   
</tbody>
@endsection