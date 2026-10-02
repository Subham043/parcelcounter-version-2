// role-modal.store.ts

import type { ExtendedModalProps } from "@/utils/types";
import { create } from "zustand";

type ChargeModalStore = {
    modal: ExtendedModalProps<{ id: number }>;

    handleModalOpen: () => void;
    handleModalClose: () => void;
    handleModalEdit: (id: number) => void;
};

const initialState = {
    modal: {
        show: false,
        type: "create" as const,
    },
};

export const useChargeModalStore =
    create<ChargeModalStore>((set) => ({
        modal: initialState.modal,

        handleModalOpen: () =>
            set({
                modal: {
                    show: true,
                    type: "create" as const,
                },
            }),

        handleModalClose: () =>
            set({
                modal: {
                    show: false,
                    type: "create" as const,
                },
            }),

        handleModalEdit: (id: number) =>
            set({
                modal: {
                    show: true,
                    type: "update" as const,
                    id,
                },
            }),
    }));