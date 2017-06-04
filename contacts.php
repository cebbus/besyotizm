<?php
include_once 'inc/includes.php';
include_once 'util/SystemVariables.php';
include_once 'util/DatabaseUtils.php';

ob_start();
?>

<script type="text/javascript">
function sendMail() {
	var error = validate();
	if(!error){
		var name = $("#NAME_SURNAME").val();
		var email = $("#EMAIL").val();
		var content = $('#MESSAGE').val() + '%0D%0A%0D%0A';
		
		var data = "from=" + email + "&to=besyotizm@hotmail.com" + 
					"&subject=Besyotizm Sitesinden Mail" + "&content=" + name + '\r\n' +content;

		$.ajax({
			type: "POST",
			url: "send.php",
			data: data,
			success: function(){					
				$("#loading").fadeOut(100).hide();
				$('#message-sent').fadeIn(500).show();
				setTimeout(function(){
					$('#message-sent').fadeOut(500).hide();
				}, 5000);
			}
		});
	}
}

function validate(){
    var error = false, emailFormat = true;
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    
    if($('#NAME_SURNAME').val() == ''){
    	$('#NAME_SURNAME').css('background-color','#FF2929');
    	error = true;
    }else{
    	$('#NAME_SURNAME').css('background-color','');
    }

    if($('#EMAIL').val() == ''){
    	$('#EMAIL').css('background-color','#FF2929');
    	error = true;
    }else{
    	emailFormat = emailPattern.test($('#EMAIL').val());
    	$('#EMAIL').css('background-color','');
    }

    if($('#MESSAGE').val() == ''){
    	$('#MESSAGE').css('background-color','#FF2929');
    	error = true;
    }else{
    	$('#MESSAGE').css('background-color','');
    } 

    if(error){
    	$('#mailErrorMessage').html('<?php echo $lang['EMPTY_FIELD_MESSAGE'];?>');
    	$('#mailErrorMessage').css('visibility','visible');            
    }else{
        if(!emailFormat){
        	$('#EMAIL').css('background-color','#FF2929');
        	$('#mailErrorMessage').html('<?php echo $lang['EMAIL_MESSAGE'];?>');
        	$('#mailErrorMessage').css('visibility','visible');             
            error = true;
        }else{
        	$('#mailErrorMessage').css('visibility','hidden');
        }
    }

    return error;
}

function resetForm(){
   	$('#form').each (function(){
    	this.reset();
    });
}
</script>

<div class="grid_12">
	<div class="box-shadow">
		<div class="wrap block-2">
			<div class="col-3">
				<h2>
					<span class="color-1">Ziyaret</span> edebilirsiniz
				</h2>
				<div class="map img-border">
					<iframe width="200" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps/ms?msa=0&amp;msid=215275136148618354540.0004de7ef29f01436fa62&amp;ie=UTF8&amp;t=h&amp;ll=40.283152,28.942966&amp;spn=0,0&amp;output=embed"></iframe><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=tr&amp;geocode=&amp;q=Nil%C3%BCfer+K%C3%B6y+%2F+Osmangazi+%2F+Bursa+Akasya+Sk&amp;aq=&amp;sll=40.264087,28.961613&amp;sspn=0.009628,0.017982&amp;ie=UTF8&amp;hq=&amp;hnear=Fatih+Sultan+Mehmet+Mh.,+Akasya+Cd,+Bursa%2FOsmangazi,+T%C3%BCrkiye&amp;t=m&amp;ll=40.264071,28.961592&amp;spn=0.013099,0.01708&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left"></a></small>				
					<!-- <iframe width="200" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=tr&amp;geocode=&amp;q=Nil%C3%BCfer+K%C3%B6y+%2F+Osmangazi+%2F+Bursa+Akasya+Sk&amp;aq=&amp;sll=40.264087,28.961613&amp;sspn=0.009628,0.017982&amp;ie=UTF8&amp;hq=&amp;hnear=Fatih+Sultan+Mehmet+Mh.,+Akasya+Cd,+Bursa%2FOsmangazi,+T%C3%BCrkiye&amp;t=m&amp;ll=40.264071,28.961592&amp;spn=0.013099,0.01708&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=tr&amp;geocode=&amp;q=Nil%C3%BCfer+K%C3%B6y+%2F+Osmangazi+%2F+Bursa+Akasya+Sk&amp;aq=&amp;sll=40.264087,28.961613&amp;sspn=0.009628,0.017982&amp;ie=UTF8&amp;hq=&amp;hnear=Fatih+Sultan+Mehmet+Mh.,+Akasya+Cd,+Bursa%2FOsmangazi,+T%C3%BCrkiye&amp;t=m&amp;ll=40.264071,28.961592&amp;spn=0.013099,0.01708&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left"></a></small> -->
				</div>
				<dl>
					<dt class="color-1">
						<strong>Nilüferköy Mah. Akasya Sk. NO:7/1<br>Nilüferköy / Osmangazi / Bursa
						</strong>
					</dt>
					<dd>
						<span>Telefon:</span>0 546 578 05 90
					</dd>
					<dd>
						<span>Telefon:</span>0 506 207 65 91
					</dd>
					<dd>
						<span></span><a href="#" class="link">besyotizm@hotmail.com</a>
					</dd>
				</dl>
			</div>
			<div class="col-4">
				<h2>
					<span class="color-1">İletişim</span> formu
				</h2>
				<form id="form" method="post">						
					<fieldset>	
						<span id="mailErrorMessage" style="visibility: hidden; color: red;"></span>
						<div style="display: none;" id="loading"><img src="images/loading.gif" /> <font color="#FF0000"><?php echo $lang['SENDING']?></font></div>
						<div style="display: none;" id="message-sent"><font color="#008040"><?php echo $lang['MESSAGE_SENT']?></font></div>							
						<label>
							<input type="text" value="Ad Soyad"
								id="<?php echo SystemVariables::$COLUMN_NAME_SURNAME;?>"
								name="<?php echo SystemVariables::$COLUMN_NAME_SURNAME;?>" 
								onBlur="if(this.value=='') this.value='Ad Soyad'"
								onFocus="if(this.value =='Ad Soyad' ) this.value=''"> 
						</label> 
						<label>
							<input type="text" value="Email"
								id="<?php echo SystemVariables::$COLUMN_EMAIL;?>"
								name="<?php echo SystemVariables::$COLUMN_EMAIL;?>" 
								onBlur="if(this.value=='') this.value='Email'"
								onFocus="if(this.value =='Email' ) this.value=''"> 
						</label> 
						<label>
							<textarea
								id="<?php echo SystemVariables::$COLUMN_MESSAGE;?>"
								name="<?php echo SystemVariables::$COLUMN_MESSAGE;?>" 					
								onBlur="if(this.value==''){this.value='Yorum'}"
								onFocus="if(this.value=='Yorum'){this.value=''}">Yorum</textarea>
						</label>
						<div class="commentBtns">
							<a href="#" class="commentButton" onclick="resetForm()">TEMİZLE</a>
							<a href="#" class="commentButton" onClick="sendMail()">GÖNDER</a>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
$content = ob_get_contents();
ob_end_clean();
include('master.php');
?>