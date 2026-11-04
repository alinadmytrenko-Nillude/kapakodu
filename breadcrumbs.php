<?php
// Ootab muutujat $breadcrumbs: [['Silt', 'url'], ['Viimane silt', null]]
// "Avaleht" lisatakse alati ise.
if (!empty($breadcrumbs)):
?>
    <nav aria-label="breadcrumb" class="container pt-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Avaleht</a></li>
<?php foreach ($breadcrumbs as $i => [$silt, $url]): ?>
<?php if ($url !== null && $i < count($breadcrumbs) - 1): ?>
            <li class="breadcrumb-item"><a href="<?= h($url) ?>" class="text-decoration-none"><?= h($silt) ?></a></li>
<?php else: ?>
            <li class="breadcrumb-item active" aria-current="page"><?= h($silt) ?></li>
<?php endif; ?>
<?php endforeach; ?>
        </ol>
    </nav>
<?php endif; ?>
