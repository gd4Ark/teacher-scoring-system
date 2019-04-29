<?php if (isset($_GET['gid'])) {
    $gid = base64_decode($_GET['gid']);
    $students = get($base_url . 'students?getOptions=1&groupId=' . $gid);
    ?>
    <?php foreach ($students as $v) : ?>
        <option value="<?php echo $v['value'] ?>"><?php echo $v['label'] ?></option>
    <?php endforeach ?>
<?php } ?>