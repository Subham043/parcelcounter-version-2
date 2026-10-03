// role-modal.store.ts

import type { ModalProps } from "@/utils/types";
import { create } from "zustand";

type ContactFormEnquiryModalStore = {
    modal: ModalProps<{ id: number }>;

    handleModalClose: () => void;
    handleModalView: (id: number) => void;
};

const initialState = {
    modal: {
        show: false as const,
    },
};

export const useContactFormEnquiryModalStore =
    create<ContactFormEnquiryModalStore>((set) => ({
        modal: initialState.modal,

        handleModalClose: () =>
            set({
                modal: {
                    show: false,
                },
            }),

        handleModalView: (id: number) =>
            set({
                modal: {
                    show: true,
                    id,
                },
            }),
    }));