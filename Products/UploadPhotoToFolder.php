<?php
if(isset($_FILES['photo'])){
    move_uploaded_file($_FILES['photo']['tmp_name'], "../Assets/" . $_FILES['photo']['name']);
}
else{
    echo "image not found!";
}
?>