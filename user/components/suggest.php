<tr class="project">
    <td colspan="3">建议</td>
    <?php foreach ($teachings as $teaching) : ?>
        <td>
            <textarea class="form-control suggest" data-teaching-id="<?php echo $teaching['id'] ?>" placeholder="填写您的建议"></textarea>
        </td>
    <?php endforeach ?>
</tr>