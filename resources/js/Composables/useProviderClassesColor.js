export default function useProviderClassesColor() {
    const getProviderTextColor = (provider) => {
        const colors = {
            'facebook': 'text-[#1877F2]',
            'twitter': 'text-[#1DA1F2]',
            'instagram': 'text-[#E4405F]',
            'linkedin': 'text-[#0A66C2]',
            'mastodon': 'text-[#6364FF]',
            'telegram': 'text-[#26A5E4]',
            'pinterest': 'text-[#BD081C]'
        };

        return colors[provider] || 'text-gray-500';
    };

    const getProviderBgColor = (provider) => {
        const colors = {
            'facebook': 'bg-[#1877F2]',
            'twitter': 'bg-[#1DA1F2]',
            'instagram': 'bg-[#E4405F]',
            'linkedin': 'bg-[#0A66C2]',
            'mastodon': 'bg-[#6364FF]',
            'telegram': 'bg-[#26A5E4]',
            'pinterest': 'bg-[#BD081C]'
        };

        return colors[provider] || 'bg-gray-500';
    };

    const getProviderBorderColor = (provider) => {
        const colors = {
            'facebook': 'border-[#1877F2]',
            'twitter': 'border-[#1DA1F2]',
            'instagram': 'border-[#E4405F]',
            'linkedin': 'border-[#0A66C2]',
            'mastodon': 'border-[#6364FF]',
            'telegram': 'border-[#26A5E4]',
            'pinterest': 'border-[#BD081C]'
        };

        return colors[provider] || 'border-gray-500';
    };

    return {
        getProviderTextColor,
        getProviderBgColor,
        getProviderBorderColor
    };
}
