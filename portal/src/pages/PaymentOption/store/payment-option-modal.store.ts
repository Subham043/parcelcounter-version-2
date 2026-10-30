// role-modal.store.ts

import type { ModalProps } from "@/utils/types";
import { create } from "zustand";

type PaymentOptionModalStore = {
    modal: ModalProps<{ id: number }>;

    handleModalClose: () => void;
    handleModalOpen: (id: number) => void;
};

const initialState = {
    modal: {
        show: false as const,
    },
};

export const usePaymentOptionModalStore =
    create<PaymentOptionModalStore>((set) => ({
        modal: initialState.modal,

        handleModalClose: () =>
            set({
                modal: {
                    show: false,
                },
            }),

        handleModalOpen: (id: number) =>
            set({
                modal: {
                    show: true,
                    id,
                },
            }),
    }));