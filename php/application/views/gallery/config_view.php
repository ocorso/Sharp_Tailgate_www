<gallery>
	<images total_pages="<?= $total_pages; ?>">
	<?php foreach($records as $i):
		$thumb 		= base_url()."images/gallery/thumb/$i->tid.jpg";
		$large		= base_url()."images/gallery/large/$i->tid.png";
		$detail		= base_url()."gallery/$i->tid";
		$createdAt	= date("F j, Y", strtotime($i->created_at));
	?>
	<item id="<?= $i->tid; ?>" value="gallery_button">
			<label><![CDATA[<?= $i->tid; ?>]]></label>
			<title><![CDATA[<?= $i->title; ?>]]></title>
			<detail><![CDATA[<?= $detail; ?>]]></detail>
			<large><![CDATA[<?= $large; ?>]]></large>
			<thumb><![CDATA[<?= $thumb; ?>]]></thumb>
			<full_name><![CDATA[<?= $i->full_name; ?>]]></full_name>
			<profile_pic><![CDATA[<?= $i->profile_pic; ?>]]></profile_pic>
			<created_at><![CDATA[<?= $createdAt; ?>]]></created_at>
		</item>
	<?php endforeach; ?>
	</images>
</gallery>