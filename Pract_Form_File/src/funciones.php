<?php
function LetraNIF($dni){
return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}
?>
