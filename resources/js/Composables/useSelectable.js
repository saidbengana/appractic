import {ref} from "vue";

export default function useSelectable() {
    const selectedItems = ref([]);
    const selectAll = ref(false);

    const isSelected = (item) => {
        return selectedItems.value.includes(item);
    };

    const toggleSelect = (item) => {
        const index = selectedItems.value.indexOf(item);

        if (index === -1) {
            selectedItems.value.push(item);
        } else {
            selectedItems.value.splice(index, 1);
        }

        updateSelectAll();
    };

    const toggleSelectAll = (items) => {
        if (selectAll.value) {
            selectedItems.value = [];
        } else {
            selectedItems.value = [...items];
        }

        selectAll.value = !selectAll.value;
    };

    const updateSelectAll = () => {
        selectAll.value = false;
    };

    const clearSelected = () => {
        selectedItems.value = [];
        selectAll.value = false;
    };

    return {
        selectedItems,
        selectAll,
        isSelected,
        toggleSelect,
        toggleSelectAll,
        clearSelected
    };
}
