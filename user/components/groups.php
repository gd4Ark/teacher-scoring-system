<?php
$gruops =  get($base_url . 'groups?getOptions=1');
$gid = isset($_GET['gid']) ? $_GET['gid'] : null;
$gid = base64_decode($gid);
?>
<?php foreach ($gruops as $v) : ?>
    <option <?php
            if ((int)$gid === $v['value']) {
                echo 'selected';
            }
            ?> value="<?php echo $v['value'] ?>"><?php echo $v['label'] ?></option>
<?php endforeach ?>