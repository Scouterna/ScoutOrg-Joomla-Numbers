<?php 

defined('_JEXEC') or die; ?>

<?php if ($showNewRegistered) : ?>
    <p>
        <?= $newRegisteredCount ?> nya intresseanmälningar de senaste <?= $newRegisteredInterval ?> dagarna.
    </p>
<? endif; ?>

<h1>
    <center>
        <?= $totalCount ?> i kö.
    </center>
</h1>

Antal scouter, antal föräldrar
<center>
    <table>
        <?php foreach ($stats as $yearStat) : ?>
            <tr>
                <td><?= $yearStat->year ?></td>
                <td><?= $yearStat->scouts ?></td>
                <td><?= $yearStat->leaders ?></td>
                <td>
                    <div height='16px' width='<?= $yearStat->scouts ?>px'
                        style='background-color:<?= $yearStat->color ?>'></div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</center>