@extends('emails.layout.master')
 @section ('content')
 <tbody>
    <tr>
        <td style="font-size:0;padding:30px 30px 18px;" align="left">
            <div class="mj-content" style="cursor:auto;color:#000000;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:24px;line-height:22px;">សូមស្វាគមន៍សមាជិកថ្មី!</div>
        </td>
    </tr>
    <tr>
        <td style="font-size:0;padding:0 30px 16px;" align="left">
            <div class="mj-content" style="cursor:auto;color:#000000;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;">សួស្តី <b>{{$data['member']}}</b></div>
        </td>
    </tr>
   
    <tr>
        <td style="font-size:0;padding:0 30px 16px;" align="left">
            <div class="mj-content" style="cursor:auto;color:#000000;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;">
              <p>
                សូមអរគុណសម្រាប់ការចុះឈ្មោះសម្រាប់ប្រព័ន្ធរបស់យើង។
              </p>
              <p>
                នេះជាព័ត៌មានរបស់អ្នក:
                <ul>
                  
                  <li>ឈ្មោះ: {{$data['member']}}</li>
                  <li>អ៊ីម៉ែល: <span style="border-bottom: solid 1px #b3bac1">{{$data['email']}} </span></li>
                  <li>លេខទូរសព្: {{$data['phone']}}</li>
                  
                </ul>
                សូមប្រើកូដនេះ <b>{{$data['code']}}</b> ដើម្បីផ្ទៀងផ្ទាត់គណនីរបស់អ្នក
              </p>
          </div>
        </td>
    </tr>
     <tr>
        <td style="font-size:0;padding:0 30px 16px;" align="left">
            <div class="mj-content" style="cursor:auto;color:#000000;font-family:Proxima Nova, Arial, Arial, Helvetica, sans-serif;font-size:15px;line-height:22px;">ដោយសេចក្ដីគោរព, <br /> <b>ក្រុមកាងារ Road Care</b></div>
        </td>
    </tr>
   
</tbody>
@endsection