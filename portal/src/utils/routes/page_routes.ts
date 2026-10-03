/*
 * Page routes list
 */
export const page_routes = {
  profile: { link: "/profile", name: "Profile" },
  reset_with_phone: { link: "/auth/reset-with-phone", name: "Forgot Password" },
  reset_with_email: { link: "/auth/reset-with-email", name: "Forgot Password" },
  login_with_phone: { link: "/auth/login-with-phone", name: "Login" },
  login_with_email: { link: "/auth/login-with-email", name: "Login" },
  login_with_phone_password: {
    link: "/auth/login-with-phone-password",
    name: "Login",
  },
  sign_up: { link: "/auth/sign-up", name: "Sign Up" },
  charges: { link: "/charges", name: "Charges" },
  delivery_slots: { link: "/delivery-slots", name: "Delivery Slots" },
  features: { link: "/features", name: "Features" },
  testimonials: { link: "/testimonials", name: "Testimonials" },
  tax: { link: "/tax", name: "Tax" },
  dashboard: { link: "/", name: "Dashboard" },
} as const;
