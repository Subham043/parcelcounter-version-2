import { DeleteContext } from "@/contexts/DeleteProvider";
import { useContext, useState } from "react";
import { useToast } from "./useToast";
import axios from "@/utils/axios";
import { toLowerCase, toTitleCase } from "@/utils/helper";

export const useDeleteConfirmation = () => {
    const { ...rest } = useContext(DeleteContext);
    const [loading, setLoading] = useState<boolean>(false);
    const { toastError, toastSuccess } = useToast();

    const onDeleteHandler = async ({
        route,
        tag,
        callback,
    }: {
        route: string;
        tag: string;
        callback: () => void;
    }) => {
        setLoading(true);
        try {
            await axios.delete(route);
            toastSuccess(toTitleCase(tag) + " deleted successfully");
            callback();
            // eslint-disable-next-line @typescript-eslint/no-explicit-any
        } catch (error: any) {
            toastError(
                error?.response?.data.message ||
                    "Failed to delete " + toLowerCase(tag),
            );
        } finally {
            setLoading(false);
        }
    };

    return {
        onDeleteHandler,
        loading,
        ...rest,
    };
};
