<tr class="project">
    <td colspan="3">总分</td>
    <?php foreach ($teachings as $teaching) : ?>
        <td class="assess-score-count" data-teaching-id="<?php echo $teaching['id'] ?>">
            0
        </td>
    <?php endforeach ?>
</tr>