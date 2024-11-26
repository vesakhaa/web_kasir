<?php $pager->setSurroundCount(2); ?>
<nav>
    <ul class="pagination">
        <?php if ($pager->hasPreviousPage()) { ?>
            <li class="page-item">
                <a href="<?= $pager->getFirst() ?>" aria-label="First" class="page-link">
                    <span aria-hidden="true">First</span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getPreviousPage() ?>" class="page-link" aria-label="Previous">
                    <span>&laquo;</span>
                </a>
            </li>
        <?php } ?>

        <?php
        foreach ($pager->links() as $link) {
            $activeclass = $link['active'] ? 'active' : '';
            ?>
            <li class="page-item <?= $activeclass ?>">
                <a href="<?= $link['uri'] ?>" class="page-link">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php } ?>

        <?php if ($pager->hasNextPage()) { ?>
            <li class="page-item">
                <a href="<?= $pager->getNextPage() ?>" aria-label="Next" class="page-link">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getLast() ?>" aria-label="Last" class="page-link">
                    <span aria-hidden="true">Last</span>
                </a>
            </li>
        <?php } ?>
    </ul>
</nav>