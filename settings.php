<?php
	// Save Data

	if ($_POST['sttw_twitch_number'] != "") {
		if (is_numeric($_POST['sttw_twitch_number'])) {
			update_option('sttw_twitch_number',$_POST['sttw_twitch_number']);
		}
	}
	if (isset($_POST['users'])) {
		$users = array();
		foreach ($_POST['users'] as $user) {
			$users[] = sanitize_text_field($user);
		}
		update_option('sttw_twitch_users',json_encode($users));
	}

	function number_input() {
		?>
		<select name="sttw_twitch_number">
			<option value="">Select...</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
		<?php
	}

	function user_input() {
		if (get_option('sttw_twitch_users') == "") {
			$value = array("", "", "");
		}else {
			$value = json_decode(get_option('sttw_twitch_users'), true);
		}
		for ($i=0;$i<get_option('sttw_twitch_number');$i++) {
			echo "User #". ($i + 1) ." <input type='text' name='users[]' value='".$value[$i]."'><br>";
		}
	}
?>

<div class="wrap">
	<h2>Simple Twitch.TV Widget Options</h2>
	<form method="post" action="">
		<?php
			if (get_option('sttw_twitch_number') == "") {
				?>
					<strong>User Number</strong><br />
					<p>
						First, you must select the number of users you would like to monitor:<br>
					</p><br><br>
				<?php
				number_input();
				?>
				<input type="submit" value="Next Step ->" class="button button-primary">
				<?php
			}elseif (get_option('sttw_twitch_users') == "") {
				?>
				<strong>Enter Users</strong><br />
				<p>
					Next, type the username(s) of the people you would like to see the status of:<br>
				</p><br>
				<?php
				user_input();
				echo "<input type='submit' value='Nest Step ->'>";
			}else {
				?>
				<strong>Edit Settings</strong><br />
					<p>
						It looks like you are all setup<br>
						You may edit any of the values below:<br>
					</p><br>
				<?php
				echo "Number of users: ";
				number_input();
				echo "<br><br>";
				user_input();
				echo "<br><input type='submit' class='button button-primary' value='Save'>";
			}
		?>
	</form>
</div>
