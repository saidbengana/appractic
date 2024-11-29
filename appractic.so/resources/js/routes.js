export const routes = {
    dashboard: 'appractic.dashboard',
    posts: {
        index: 'appractic.posts.index',
        create: 'appractic.posts.create',
        store: 'appractic.posts.store',
        edit: 'appractic.posts.edit',
        update: 'appractic.posts.update',
        delete: 'appractic.posts.delete',
        duplicate: 'appractic.posts.duplicate',
        schedule: 'appractic.posts.schedule'
    },
    calendar: 'appractic.calendar',
    media: {
        index: 'appractic.media.index'
    },
    accounts: {
        index: 'appractic.accounts.index',
        add: 'appractic.accounts.add',
        entities: {
            index: 'appractic.accounts.entities.index',
            store: 'appractic.accounts.entities.store'
        }
    },
    settings: {
        index: 'appractic.settings.index',
        update: 'appractic.settings.update'
    },
    services: {
        index: 'appractic.services.index',
        update: 'appractic.services.update'
    },
    profile: {
        index: 'appractic.profile.index',
        updateUser: 'appractic.profile.updateUser',
        updatePassword: 'appractic.profile.updatePassword'
    },
    reports: 'appractic.reports',
    logout: 'appractic.logout'
};
