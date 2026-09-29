import { base } from "./env.base.ts";


/*
 * Configuration for production env
 */

export const env_production = {
  ...base,
  MODE: "production",
  API_ENDPOINT: "http://localhost:8000",
  APP_ENDPOINT: `http://localhost:5173`,
  CAPTCHA_KEY: `6LdfpfUsAAAAAEzspaJMKkBqdFiqe34vD6xnF_au`,
} as const;
