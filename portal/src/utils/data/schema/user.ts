import * as yup from "yup";

export const userFormSchema = yup
    .object({
        is_create: yup
            .boolean()
            .optional()
            .default(true),
        name: yup
            .string()
            .typeError("Name must contain characters only")
            .required("Name is required"),
        phone: yup
            .string()
            .matches(/^[0-9]+$/, "Phone must contain numbers only")
            .length(10, "Phone must contain exactly 10 digits")
            .required("Phone is required"),
        email: yup
            .string()
            .typeError("Email must contain characters only")
            .email("Please enter a valid email")
            .optional(),
        password: yup
            .string()
            .typeError("Password must contain characters only")
            .when("is_create", {
                is: true,
                then: (schema) => schema.required("Password is required"),
            })
            .min(7, "Password is too Short!")
            .max(50, "Password is too Long!")
            .matches(/[0-9]/, "Password must contain at least one number")
            .matches(/[a-z]/, "Password must contain at least one lowercase letter")
            .matches(/[A-Z]/, "Password must contain at least one uppercase letter")
            .matches(
                /[$&+,:;=?@#|'<>.^*()%!-]/,
                "Password must contain at least one special character"
            ),
        confirm_password: yup
            .string()
            .typeError("Confirm Password must contain characters only")
            .when("is_create", {
                is: true,
                then: (schema) => schema.required("Confirm Password is required"),
            })
            .oneOf(
                [yup.ref("password")],
                "Confirm Passwords must match password entered above"
            ),
        role: yup.string().typeError("Role must contain characters only").required("Role is required"),
        is_blocked: yup
            .boolean()
            .typeError("Is Blocked must contain boolean only")
            .optional()
            .default(false),
    })
    .required();

export type UserFormValuesType = yup.InferType<typeof userFormSchema>;