export default function usePostVersions() {
    const versionObject = (accountId = 0) => {
        return {
            account_id: accountId,
            content: [
                {
                    body: '',
                    media: []
                }
            ],
            options: {
                hide_link_preview: false
            }
        };
    };

    const getOriginalVersion = (versions) => {
        return versions.find((version) => {
            return version.account_id === 0;
        });
    };

    const getAccountVersion = (versions, accountId) => {
        const version = versions.find((version) => {
            return version.account_id === accountId;
        });

        return version || getOriginalVersion(versions);
    };

    const getIndexAccountVersion = (versions, accountId) => {
        return versions.findIndex((version) => {
            return version.account_id === accountId;
        });
    };

    return {
        versionObject,
        getOriginalVersion,
        getAccountVersion,
        getIndexAccountVersion
    };
}
