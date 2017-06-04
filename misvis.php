<?php
include_once 'inc/includes.php';
include_once 'util/SystemVariables.php';
include_once 'util/DatabaseUtils.php';

ob_start();
?>

<div class="grid_12">
	<div class="block-3 box-shadow">
		<h2 class="p4"><span class="color-1">Misyon</span></h2>
		<p>
			Otizmli bireylerin becerilerini ve enerjilerini doğru kanallara 
			aktarmasını sağlayarak nitelikli yaşam sürmelerini gerçekleştirmek,	
			özgüvenlerini sağlayacak ve yoksunluklarını ortadan kaldıracak, 
			bireysel olarak yaşama bağımsızlıklarını oluşturacak, 
			sporla entegre olacak becerileri kazandırmak, ailelerinin sosyal 
			sorunlarının önlenmesi ve çözümlenmesine yardımcı olacak yaşam koşullarının 
			iyileştirilmesini sağlayacak sistemli,düzenli ve devamlı bir eğitim 
			ortamı oluşturarak bu alanla ilgili tüm kesimlerle işbirliği içinde 
			olmak yönünde çalışmaları yürütmek.
		</p>
		<br/><br/>
		<h2 class="p4"><span class="color-1">Vizyon</span></h2>
		<p>
			Otizmli bireyler ve aileleri için objektif, proaktif çözümler üreten, 
			ulaşılabilir, nitelikli yaşamlar sağlayan, ulusal ve uluslarası 
			platformlarda Otizmli bireylerin gerçekleştirdikleri gelişmeler konusunda 
			bilgisine ve deneyimine başvurulan, kamuoyunu bu konuda bilinçlendirmeyi ve 
			gönüllülüğü arttırmayı hedefleyen ve bu konuda tedbirler alan, bilimsel çalışmaları 
			bizzat gerçekleştiren ve akademik çevreyi yönlendiren danışman ve bu alandaki 
			hizmetlerini sosyal ortamlara yayma alanında lider bir kurum olmak.
		</p>
		<br/><br/>
		<h2 class="p4"><span class="color-1">Otizmli </span>Sporculara Yönelik Amaçlarımız</h2>
		<p>
			<b>1.</b>Otizmli bireylere spor becerilerini kazandırmak sureti ile iletişim, etkileşim, sosyalleşme ve topluma entegre olma yetilerini kazandırmak, arttırmak ve sürdürmelerini sağlamak.<br/>
			<b>2.</b>Otizmli bireylerin bu yolla kendilerine bir amaç belirleyerek, onları toplumdan adeta soyutlayan	davranış problemlerini ortadan kaldırmak ve arzulanan davranışlarla birlikte otokontrol	mekanizmalarını oluşturmak, arttırmak ve yaşamları boyunca sürdürmelerini sağlamak..<br/>
			<b>3.</b>Otizmli bireylerin bağımsız yaşamalarına katkıda bulunacak özbakım becerilerinin,spor aktiviteleri ile desteklenen küçük kas gelişimi, dikkat ve konsantrasyon artışı ve el-göz koordinasyonunun arttırılması sureti ile kazandırılması, arttırılması ve sürdürülmesini sağlamak..<br/>
			<b>4.</b>Alanında uzman;spor-yaşam liderleri’nin verdikleri tam zamanlı ve yarı zamanlı eğitimler sayesinde; otizmli bireyleri ’sporcu olarak’ hayata kazandırmak, yurt içi ve yurt dışı yarışmalarda paralimpik olimpiyatlarda , kendilerini kanıtlamalarını sağlayacak   sporcular yetiştirmek..<br/>
		</p>	
		<br/><br/>
		<h2 class="p4"><span class="color-1">Kurumsal </span>Sosyal Sorumluluğa Yönelik Amaçlarımız</h2>
		<p>
			<b>1.</b>Toplumu bilinçlendirerek, tüm iç ve dış paydaşlara karşı <b>‘dürüst ve sorumlu’</b> davranarak bilinçlendirme kampanyaları ve tanıtımları ile otizmde farkındalığı olan bir kamuoyu  oluşturmak, sivil toplum örgütleri ile bu konuda projeler üretmek ve yerine getirmek,akademik	çevrelerinde desteğini alarak yurtiçi ve yurtdışında bilimsel çalışmalar üretmek, rehberlik ve liderlik etmek.<br/> 
			<b>2.</b>Onurlu ve nitelikli yaşam ihtiyacı duyan, sosyal hayatın içinde otizmli evlatları ile daha kaliteli yaşam standartlarına kavuşmayı arzulayan ailelere, planlı ve sistemli eğitim ortamını yaratmak üzere organizasyonlar yapmak ve devamlılığını sağlamak.<br/>
			<b>3.</b>Okulların kaynaştırma sınıflarında olan otizmli bireylerin Bireysel Eğitim Programına (BEP)  paralel olarak hazırlanan sistemlerine hitap eden programları yürütmek ve okul ortamındaki normal gelişim gösteren bireylerle uyum ve birlikte çalışma yetilerini oluşturmak, arttırmak ve sürdürmelerini sağlamak.<br/>
		</p>				
	</div>
</div>

<?php
$content = ob_get_contents();
ob_end_clean();
include('master.php');
?>