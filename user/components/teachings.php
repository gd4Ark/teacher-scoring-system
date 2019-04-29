<?php
$teachings = get($base_url . 'teachings?getOptions=1&groupId=' . $_GET['gid']);
?>
<?php foreach ($teachings as $teaching) : ?>
    <td class="teacher_info" data-teaching-id="<?php echo $teaching['id'] ?>">
        <span><?php echo $teaching['subject']['label'] ?></span>
        <span><?php echo $teaching['teacher']['label'] ?></span>
    </td>
<?php endforeach ?>