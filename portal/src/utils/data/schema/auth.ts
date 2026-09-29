import * as yup from "yup";

export const emailoginSchema = yup
    .object({
        email: yup
            .string()
            .typeError("Email must contain characters only")
            .email("Please enter a valid email")
            .required("Email is required"),
        password: yup
            .string()
            .typeError("Password must contain characters only")
            .required("Password is required"),
        captcha: yup.string().typeError("Captcha must contain characters only").required("Captcha is required"),
    })
    .required();

export type EmailLoginFormValuesType = yup.InferType<typeof emailoginSchema>;

export const phonePasswordLoginFormSchema = yup
    .object({
        phone: yup
            .string()
            .matches(/^[0-9]+$/, "Phone must contain numbers only")
            .length(10, "Phone must contain exactly 10 digits")
            .required("Phone is required"),
        password: yup
            .string()
            .typeError("Password must contain characters only")
            .required("Password is required"),
        captcha: yup.string().typeError("Captcha must contain characters only").required("Captcha is required"),
    })
    .required();

export type PhonePasswordLoginFormValuesType = yup.InferType<typeof phonePasswordLoginFormSchema>;

export const emailForgotPasswordSchema = yup
    .object({
        email: yup
            .string()
            .typeError("Email must contain characters only")
            .email("Please enter a valid email")
            .required("Email is required"),
        captcha: yup.string().typeError("Captcha must contain characters only").required("Captcha is required"),
    })
    .required();

export type EmailForgotPasswordFormValuesType = yup.InferType<typeof emailForgotPasswordSchema>;

export const phoneForgotPasswordSchema = yup
    .object({
        phone: yup
            .string()
            .matches(/^[0-9]+$/, "Phone must contain numbers only")
            .length(10, "Phone must contain exactly 10 digits")
            .required("Phone is required"),
        captcha: yup.string().typeError("Captcha must contain characters only").required("Captcha is required"),
    })
    .required();

export type PhoneForgotPasswordFormValuesType = yup.InferType<typeof phoneForgotPasswordSchema>;

export const resetPasswordSchema = yup
    .object({
        otp: yup
            .string()
            .typeError("Otp must contain numbers only")
            .length(6, "Otp must contain exactly 6 digits")
            .required("Otp is required"),
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
        password_confirmation: yup
            .string()
            .typeError("Confirm Password must contain characters only")
            .required("Confirm Password is required")
            .oneOf(
                [yup.ref("password")],
                "Confirm Passwords must match password entered above"
            ),
        captcha: yup.string().typeError("Captcha must contain characters only").required("Captcha is required"),
    })
    .required();

export type ResetPasswordFormValuesType = yup.InferType<typeof resetPasswordSchema>;

export const registerSchema = yup
    .object({
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
            .oneOf(
                [yup.ref("password")],
                "Confirm Passwords must match password entered above"
            ),
        role: yup.string().typeError("Role must contain characters only").oneOf(["Referral Rockstars", "Reward Riders", "App Promoter"]).required("Role is required"),
        referral_code: yup.string().typeError("Referral Code must contain characters only").optional(),
        captcha: yup.string().typeError("Captcha must contain characters only").required("Captcha is required"),
    })
    .required();

export type RegisterFormValuesType = yup.InferType<typeof registerSchema>;