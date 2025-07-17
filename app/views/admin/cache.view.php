<?php get_header('admin'); ?>
<?php get_navbar('admin'); ?>
<?php get_sidebar('admin'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cache Management</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="<?= url('/admin/cache/update') ?>" method="post">
                        <div class="form-group">
                            <label>Cache Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="cacheSwitch" name="cache_enabled" <?= Core\Utils\Cache::isEnabled() ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="cacheSwitch">Enable File Caching</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="<?= url('/admin/cache/clear') ?>" method="post">
                        <div class="form-group">
                            <label>Clear Cache</label>
                            <p>This will remove all cached files.</p>
                        </div>
                        <button type="submit" class="btn btn-danger">Clear Cache</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer('admin'); ?>
