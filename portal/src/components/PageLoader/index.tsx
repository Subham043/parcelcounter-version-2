import { Loader2 } from "lucide-react";
import logo from "@/assets/images/logo.webp";

export default function PageLoader() {
  return (
    <div className="flex min-h-dvh items-center justify-center px-4">
      <div className="flex flex-col items-center justify-center space-y-4 text-center">
        <img src={logo} alt="Logo" className="h-17.5 w-auto object-contain" />

        <h2 className="text-sm font-semibold">
          Please wait while we setup the app...
        </h2>

        <Loader2 className="h-6 w-6 animate-spin text-primary" />
      </div>
    </div>
  );
}
