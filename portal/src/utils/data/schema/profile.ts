import * as yup from "yup";

export const profileUpdateFormSchema = yup
    .object()
    .shape({
        name: yup
            .string()
            .typeError("Name must contain characters only")
            .required("Name is required"),
        email: yup
            .string()
            .typeError("Email must contain characters only")
            .email("Please enter a valid email")
            .required("Email is required"),
        phone: yup
            .string()
            .matches(/^[0-9]+$/, "Phone must contain numbers only")
            .length(10, "Phone must contain exactly 10 digits")
            .optional(),
    })
    .required();


export type ProfileUpdateFormValuesType = yup.InferType<
    typeof profileUpdateFormSchema
>;

export const passwordUpdateFormSchema = yup
    .object()
    .shape({
        old_password: yup
            .string()
            .typeError("Old Password must contain characters only")
            .required("Old Password is required"),
        password: yup
            .string()
            .typeError("Password must contain characters only")
            .required("Password is required")
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
            .required("Confirm Password is required")
            .oneOf([yup.ref("password")], "Passwords must match"),
    })
    .required();


export type PasswordUpdateFormValuesType = yup.InferType<
    typeof passwordUpdateFormSchema
>;