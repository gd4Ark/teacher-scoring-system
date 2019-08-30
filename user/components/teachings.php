<?php
$teachings = getOptions('teachings', [
  'group_id' => $gid
]);
?>
<?php foreach ($teachings as $teaching) : ?>
  <td class="teacher_info" data-teaching-id="<?php echo $teaching['id'] ?>" data-teacher-id="<?php echo $teaching['teacher']['value'] ?>" data-subject-id="<?php echo $teaching['subject']['value'] ?>">
    <span><?php echo $teaching['subject']['label'] ?></span>
    <span><?php echo $teaching['teacher']['label'] ?></span>
  </td>
<?php endforeach ?>
