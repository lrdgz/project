<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerAz7NkPq\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerAz7NkPq/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerAz7NkPq.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerAz7NkPq\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerAz7NkPq\App_KernelDevDebugContainer([
    'container.build_hash' => 'Az7NkPq',
    'container.build_id' => '1a9014ef',
    'container.build_time' => 1580391275,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerAz7NkPq');
