

<table class="table">
   <tbody>
      <tr class="fw-semibold">
         <td>Tài khoản</td>
         <td><?php echo $user['username'] ?></td>
      </tr>

      <tr class="fw-semibold">
         <td>Mật khẩu</td>
         <td>*** (<a href="/?page=user&tab=change-password">Đổi mật khẩu</a>)</td>
      </tr>

      <tr class="fw-semibold">
         <td>Số dư</td>
         <td><?php echo $user['vnd'] ?> P</td>
      </tr>

      <tr class="fw-semibold">
         <td>Số điện thoại</td>
         <td><?php echo $user['phone'] ?></td>
      </tr>

      <tr class="fw-semibold">
         <td>Email</td>
         <td><?php echo $user['email'] ?> </td>
      </tr>

      <tr class="fw-semibold vip">
         <td>Nhóm thành viên</td>
         <style>
            .fw-semibold td .id b{
               font-weight: 700;
               font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
               text-decoration: none;
               text-transform: uppercase;
               text-decoration: underline wavy;
               font-weight: bold;
               background-color: #dcf8ff;
               letter-spacing: 2px;
            }
         </style>
         <?php
            if($user['vip'] == '0') {echo'<td style="color: rgb(26 106 205);"><div class="id"><b>VIP 0</b></div></td>';}
            if($user['vip'] == '1') {echo'<td style="color: rgb(60 207 0);"><div class="id"><b>VIP 1 ✧</b></div></td>';}
            if($user['vip'] == '2') {echo'<td style="color: rgb(253 210 11);"><div class="id"><b>VIP 2 ✧✧</b></div></td>';}
            if($user['vip'] == '3') {echo'<td style="color: rgb(253 68 13);"><div class="id"><b>VIP 3 ✧✧✧</b></div></td>';}
            if($user['vip'] == '4') {echo'<td style="color: rgb(199 7 255);"><div class="id"><b>VIP 4 ✧</b></div></td>';}
            if($user['vip'] == '5') {
            
            echo'<script type="text/javascript">  // hieu ung mau chu 
            function toSpans(span) {
               var str=span.firstChild.data;
               var a=str.length;
               span.removeChild(span.firstChild);
               for(var i=0; i<a; i++) {
                  var theSpan=document.createElement("SPAN");
                  theSpan.appendChild(document.createTextNode(str.charAt(i)));
                  span.appendChild(theSpan);
               }
            }
      
            function RainbowSpan(span, hue, deg, brt, spd, hspd) {
               this.deg=(deg==null?360:Math.abs(deg));
               this.hue=(hue==null?0:Math.abs(hue)%360);
               this.hspd=(hspd==null?3:Math.abs(hspd)%360);
               this.length=span.firstChild.data.length;
               this.span=span;
               this.speed=(spd==null?50:Math.abs(spd));
               this.hInc=this.deg/this.length;
               this.brt=(brt==null?255:Math.abs(brt)%256);
               this.timer=null;
               toSpans(span);
               this.moveRainbow();
            }
            RainbowSpan.prototype.moveRainbow = function() {
               if(this.hue>359) this.hue-=360;
               var color;
               var b=this.brt;
               var a=this.length;
               var h=this.hue;
        
               for(var i=0; i<a; i++) {
        
                  if(h>359) h-=360;
         
                  if(h<60) { color=Math.floor(((h)/60)*b); red=b;grn=color;blu=0; }
                  else if(h<120) { color=Math.floor(((h-60)/60)*b); red=b-color;grn=b;blu=0; }
                  else if(h<180) { color=Math.floor(((h-120)/60)*b); red=0;grn=b;blu=color; }
                  else if(h<240) { color=Math.floor(((h-180)/60)*b); red=0;grn=b-color;blu=b; }
                  else if(h<300) { color=Math.floor(((h-240)/60)*b); red=color;grn=0;blu=b; }
                  else { color=Math.floor(((h-300)/60)*b); red=b;grn=0;blu=b-color; }
      
                  h+=this.hInc;
         
                  this.span.childNodes[i].style.color="rgb("+red+", "+grn+", "+blu+")";
               }
               this.hue+=this.hspd;
            }
            </script>';
            echo'<td style="color: rgb(253 68 13);"><div class="id"><b id="r1">VIP 5 ✧✧✧✧✧</b></div></td>';
            echo'<script type="text/javascript">
            var r1=document.getElementById("r1"); //get span to apply rainbow
            var myRainbowSpan=new RainbowSpan(r1, 0, 360, 255, 50, 18); //apply static rainbow effect
            myRainbowSpan.timer=window.setInterval("myRainbowSpan.moveRainbow()", myRainbowSpan.speed);
            </script>';}
         ?>
      </tr>

      <tr class="fw-semibold">
         <td>Trạng thái</td>
         <td class="text-success fw-bold"><?php echo getStatusUser($user['kh']); ?></td>
      </tr>

      <tr class="fw-semibold">
         <td>Ngày tham gia</td>
         <td><?php echo $user['created_at'] ?></td>
      </tr>
   </tbody>
</table>