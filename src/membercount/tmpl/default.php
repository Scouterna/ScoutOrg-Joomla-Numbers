<?php 

defined('_JEXEC') or die; ?>

<?php if ($helper->getShowOverview()) : ?>
    <center>
        <h1><?= $helper->getTotalCount() ?> Medlemmar</h1>
        <h2>varav</h2>
        <h2><?= $helper->getLeaderCount() ?> ledare</h2>
        <h2><?= $helper->getOfficerCount() ?> funktionärer</h2>
    </center>
<?php endif; ?>

<?php if ($helper->getShowScoutTable()) : ?>
    <center>
        <table>
            <?php foreach ($helper->getStats() as $yearStat) : ?>
                <tr>
                    <td><?= $yearStat->year ?></td>
                    <td><?= $yearStat->scouts ?></td>
                    <td>
                        <div style="height:16px;width:<?= $yearStat->scouts ?>px;
                            background-color:<?= $yearStat->color ?>;"></div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </center>
<?php endif; ?>

<?php if ($helper->getShowNewMembers()) : ?>
    <p>
        <?= $helper->getNewMembersCount() ?> nya medlemmar de senaste <?= $helper->getNewMembersInterval() ?> dagarna.
    </p>
<?php endif; ?>