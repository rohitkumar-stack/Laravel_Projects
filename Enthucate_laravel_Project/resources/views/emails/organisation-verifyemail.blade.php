@extends('layouts.app')

@section('content')
<center>
   <table style="width: 560px">
      <tbody>
        
         <tr style="position: relative; top: 4px;font-family:Tahoma, Geneva, sans-serif; ">
            <td colspan="2" style="text-align: center; font-weight:500; font-size: 26px;  padding: 20px 0; border-bottom: solid 3px #FA8231; background:#FA8231; color: #fff; font-family:Tahoma, Geneva, sans-serif;" "="">
               <div>Welcome to Enthucate!</div>
            </td>
         </tr>
         <tr style="background: #fff;font-family:Tahoma, Geneva, sans-serif;">
            <td colspan="2" style="padding: 30px 30px 0 30px;">
               <div style="padding: 0 0 10px 0; font-size: 16px; text-align: left; line-height:24px">
                  <span style="display: block; font-size:18px;">Hi,</span>
                  <span style="display: block; padding-top:10px;">{{$username}} Invited you to signup with Enthucate, Please go through the link below and fill your information.</span>
                  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<a href="{{ url($loginurl) }}" style="color:#ffffff;text-decoration:none; text-align:center;background:#FA8231;display: inline-block;padding: 10px 20px;">click here</a><span style="display: block; padding-top:10px;"></span>
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <table style="padding:0 30px 30px 30px;">
                  <tbody>
                     <tr style="font-size: 16px; text-align: left; line-height:24px;font-family:Tahoma, Geneva, sans-serif;">
                        <td><br></td>
                        <td><br></td>
                     </tr>
                     <tr style="font-size: 16px; text-align: left; line-height:24px;font-family:Tahoma, Geneva, sans-serif;">
                        <td colspan="2">&nbsp;If you have any problem, please contact us at admin@enthucate.com</td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
         <tr style="position:relative;  font-family:Tahoma, Geneva, sans-serif;">
            <td colspan="2" style="color: #fff; padding: 20px 30px; background:#FA8231;  border-top: 3px solid #FA8231;font-size:18px;">
               <div>Thanks,</div>
               <div>Enthucate Team</div>
            </td>
         </tr>
      </tbody>
   </table>
</center>
@endsection