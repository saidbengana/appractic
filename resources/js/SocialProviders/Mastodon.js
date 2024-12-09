export default {
    name: 'mastodon',

    options: {
        character_limit: 500,
        media_limit: 4,
        simultaneous_posting_on_multiple_accounts: true,
    },

    connect(clientId, redirectUri) {
        const scope = 'read write push';
        const responseType = 'code';

        return {
            scope,
            response_type: responseType,
            client_id: clientId,
            redirect_uri: redirectUri
        };
    },

    getAuthorizationUrl(instance, params) {
        const queryString = Object.keys(params)
            .map(key => `${key}=${encodeURIComponent(params[key])}`)
            .join('&');

        return `https://${instance}/oauth/authorize?${queryString}`;
    }
};
