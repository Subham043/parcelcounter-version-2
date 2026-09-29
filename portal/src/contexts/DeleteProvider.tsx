import React, { createContext, useState } from "react";
import * as yup from "yup";
import { yupResolver } from "@hookform/resolvers/yup";
import { Controller, type Resolver, useForm } from "react-hook-form";
import SuspenseOutlet from "@/components/SuspenseOutlet";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from "@/components/ui/alert-dialog";
import { Field, FieldError, FieldGroup } from "@/components/ui/field";
import { Input } from "@/components/ui/input";

interface ConfirmForm {
    confirmation: "DELETE";
}

const schema = yup
    .object()
    .shape({
        confirmation: yup
            .string()
            .oneOf(["DELETE"], "You must enter DELETE to confirm.")
            .required("Confirmation is required"),
    })
    .required();

type ModalProps =
    | {
          status: true;
          callback: () => Promise<void> | void;
      }
    | {
          status: false;
      };

/*
 * Delete Context Type
 */
type DeleteContextType = {
    deleteModal: boolean;
    handleDeleteModalOpen: (callback: () => Promise<void> | void) => void;
    handleDeleteModalClose: () => void;
};

/*
 * Delete Context Default Value
 */
const deleteDefaultValues: DeleteContextType = {
    deleteModal: false,
    handleDeleteModalOpen: async (callback: () => Promise<void> | void) => {
        await callback();
    },
    handleDeleteModalClose: () => {},
};

/*
 * Delete Context
 */
// eslint-disable-next-line react-refresh/only-export-components
export const DeleteContext =
    createContext<DeleteContextType>(deleteDefaultValues);

/*
 * Delete Provider
 */
const DeleteProvider: React.FC = () => {
    const [deleteModal, setDeleteModal] = useState<ModalProps>({
        status: false,
    });

    const { handleSubmit, control, reset } = useForm<ConfirmForm>({
        resolver: yupResolver(schema) as Resolver<{ confirmation: "DELETE" }>,
    });

    const handleDeleteModalClose = () => {
        setDeleteModal({ status: false });
        reset({
            confirmation: undefined,
        });
    };
    const handleDeleteModalOpen = (callback: () => Promise<void> | void) =>
        setDeleteModal({ status: true, callback });

    const deleteHandler = async () => {
        if (deleteModal.status) {
            deleteModal.callback();
        }
        handleDeleteModalClose();
    };

    return (
        <DeleteContext.Provider
            value={{
                deleteModal: deleteModal.status,
                handleDeleteModalOpen,
                handleDeleteModalClose,
            }}
        >
            <SuspenseOutlet />
            <AlertDialog
                open={deleteModal.status}
                onOpenChange={(v) => {
                    if (!v) {
                        handleDeleteModalClose();
                    }
                }}
            >
                <AlertDialogContent>
                    <form onSubmit={handleSubmit(deleteHandler)}>
                        <AlertDialogHeader>
                            <AlertDialogTitle>
                                Are you absolutely sure?
                            </AlertDialogTitle>
                            <AlertDialogDescription>
                                This action cannot be undone. This will
                                permanently delete the data from the system.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <FieldGroup className="py-3">
                            <Controller
                                name="confirmation"
                                control={control}
                                render={({ field, fieldState }) => (
                                    <Field data-invalid={fieldState.invalid}>
                                        <Input
                                            {...field}
                                            aria-invalid={fieldState.invalid}
                                            placeholder='Are you sure about it? If yes then type "DELETE"'
                                            autoComplete="off"
                                        />
                                        {fieldState.invalid && (
                                            <FieldError
                                                errors={[fieldState.error]}
                                            />
                                        )}
                                    </Field>
                                )}
                            />
                        </FieldGroup>
                        <AlertDialogFooter>
                            <AlertDialogCancel>Cancel</AlertDialogCancel>
                            <AlertDialogAction
                                type="submit"
                                variant="destructive"
                            >
                                Delete
                            </AlertDialogAction>
                        </AlertDialogFooter>
                    </form>
                </AlertDialogContent>
            </AlertDialog>
        </DeleteContext.Provider>
    );
};

export default DeleteProvider;
