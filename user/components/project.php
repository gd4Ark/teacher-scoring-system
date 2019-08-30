<?php
function getTd($current, $key1, $key2, $col, $teachings)
{
    $key = $current['key'];
    $val = $current['val'];
    $html = "<td data-title='$key1-$key2'>{$key} ({$val})</td>";
    $title = $key1 . '-' . $key2;
    for ($i = 0; $i < $col; $i++) {
        $teaching = $teachings[$i];
        $teaching_id = $teaching['id'];
        $_title = $title . '-' . $teaching_id;
        $id = $_title . '-' . $key;
        $html .= "<td class='select'>
            <input type='radio' class='radio' id='$id' name='$_title' value='$val' data-teaching-id='$teaching_id'>
            <label for='$id'></label>
        </td>";
    }
    return $html;
}

function getSubProject($project, $sub)
{
    $project_text = $project['key'] . '-' . $sub['key'];
    return "<td rowspan={$sub['row']} data-sub-project='$project_text'>{$sub['key']}</td>";
}

function getTbody($projects, $teachings)
{
    $col = count($teachings);
    $result = "";
    foreach ($projects as $project) {
        $html = "<tr class='project'><td class='title' rowspan={$project['row']}>{$project['key']}</td>";
        foreach ($project['items'] as $index => $v) {
            if ($index === 0) {
                $html .= getSubProject($project, $v);
                $html .= getTd($v['items'][0], $project['key'], $v['key'], $col, $teachings);
                $html .= "</tr>";
                continue;
            }

            $prev = $project['items'][$index - 1];

            for ($i = 1; $i < $prev['row']; $i++) {
                $tds = getTd($prev['items'][$i], $project['key'], $prev['key'], $col, $teachings);
                $html .= "<tr>{$tds}</tr>";
            }

            $html .= "<tr class='special'>";
            $html .= getSubProject($project, $v);
            $html .= getTd($v['items'][0], $project['key'], $v['key'], $col, $teachings);
            $html .= "</tr>";
        }

        $last = end($project['items']);

        for ($i = 1; $i < $last['row']; $i++) {
            $tds = getTd($last['items'][$i], $project['key'], $last['key'], $col, $teachings);
            $html .= "<tr>{$tds}</tr>";
        }

        $result .= $html;
    }

    return $result;
}

?>
<?php echo getTbody($projects, $teachings) ?>