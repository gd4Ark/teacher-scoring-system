<?php if (isset($_GET['gid'])) {
  $gid = base64_decode($_GET['gid']);
  $students = getOptions('students', [
    'group_id' =>  $gid
  ]);
  ?>
  <?php foreach ($students as $v) : ?>
    <option value="<?php echo $v['value'] ?>"><?php echo $v['label'] ?></option>
  <?php endforeach ?>
<?php } ?>
