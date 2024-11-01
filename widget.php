<table style='width:100%'>
	<tr>
		<?php
			$loop_count = get_option('sttw_twitch_number');
			$user_arr = json_decode(get_option('sttw_twitch_users'), true);
			for ($i=0;$i<$loop_count;$i++) {
				$url = "https://api.twitch.tv/kraken/streams/" . ($user_arr[$i]);
				$json = file_get_contents($url);
				$obj = json_decode($json, true);

				$width = (100 / (get_option('sttw_twitch_number')));

				if ($obj[stream] == "") {
					?>
						<td align='right'>
							<table style="width:<?php echo $width; ?>%">
							<tr>
								<td align="center">
									<strong>
										<?php echo $user_arr[$i];?>
									</strong><br>is OFFLINE
								</td>
							</tr>
							<tr>
								<td align="center">
										<img src='<?php echo STTW_URL."/assets/images/placeholder.png";?>' style='width:80px;height:45px'>
								</td>
							</tr>
							</table>
						</td>
					<?php
				}else {
					$img = $obj[stream][preview][small];
					$link = $obj[stream][channel][url];
					?>
						<td align='right'>
							<table style="width:<?php echo $width; ?>%">
								<tr>
									<td align="center">
										<strong>
											<?php echo $user_arr[$i];?>
										</strong><br> is ONLINE</td>
								</tr>
								<tr>
									<td align="center">
										<a href='<?php echo $link; ?>'>
											<img src='<?php echo $img; ?>' style='width:80px;height:45px'>
										</a>
									</td>
								</tr>
							</table>
						</td>
					<?php
				}
			}
		?>
	</tr>
</table>
