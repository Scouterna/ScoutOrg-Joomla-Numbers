<?php 

defined('_JEXEC') or die; ?>

<?php if ($helper->getShowOverview()) : ?>
    <h1>
        <center>
            <?= $helper->getTotalCount() ?> i kö.
        </center>
    </h1>
<?php endif; ?>

<?php if ($helper->getShowTable()) : ?>
    Antal scouter, antal föräldrar
    <center>
        <table>
            <?php foreach ($helper->getStats() as $yearStat) : ?>
                <tr>
                    <td><?= $yearStat->year ?></td>
                    <td><?= $yearStat->scouts ?></td>
                    <td><?= $yearStat->leaders ?></td>
                    <td>
                        <div style="height:16px;width:<?= $yearStat->scouts ?>px;
                            background-color:<?= $yearStat->color ?>;"></div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </center>
<?php endif; ?>

<?php if ($helper->getShowNewRegistered()) : ?>
    <p>
        <?= $helper->getNewRegisteredCount() ?> nya intresseanmälningar de senaste <?= $helper->getNewRegisteredInterval() ?> dagarna.
    </p>
<?php endif; ?>