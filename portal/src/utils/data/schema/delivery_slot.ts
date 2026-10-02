import * as yup from "yup";

export const deliverySlotFormSchema = yup
    .object()
    .shape({
        name: yup
            .string()
            .typeError("Name must contain characters only")
            .max(255, "Name is too Long!")
            .required("Name is required"),
        is_cod_allowed: yup
            .boolean()
            .typeError("Is COD allowed must contain boolean only")
            .optional()
            .default(false),
        start_time: yup
            .string()
            .required("Start time is required")
            .matches(
                /^([01]\d|2[0-3]):([0-5]\d)$/,
                "Start time must be in HH:mm format",
            ),
        end_time: yup
            .string()
            .required("End time is required")
            .matches(
                /^([01]\d|2[0-3]):([0-5]\d)$/,
                "End time must be in HH:mm format",
            )
            .test(
                "after-start-time",
                "End time must be after start time",
                function (endTime) {
                    const { start_time } = this.parent;

                    if (!start_time || !endTime) {
                        return true;
                    }

                    return endTime > start_time;
                },
            ),
        is_active: yup
            .boolean()
            .typeError("Is Active must contain boolean only")
            .optional()
            .default(true),
    })
    .required();


export type DeliverySlotFormValuesType = yup.InferType<
    typeof deliverySlotFormSchema
>;