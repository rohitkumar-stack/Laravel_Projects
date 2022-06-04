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
                  <span style="display: block; padding-top:10px;">{{$otp}} </span>
               </div>
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