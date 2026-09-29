import SuspenseOutlet from "@/components/SuspenseOutlet";
import { FieldDescription } from "@/components/ui/field";
import logo from "@/assets/images/logo.webp";

function AuthPageLayout() {
  return (
    <div className="flex min-h-svh flex-col items-center justify-center gap-6 bg-muted p-6 md:p-10">
      <div className="flex w-full max-w-sm flex-col">
        <a href="#" className="flex items-center self-center font-medium">
          <img src={logo} className="object-contain size-36" />
        </a>
        <div className="flex flex-col gap-4">
          <SuspenseOutlet />
          <FieldDescription className="px-6 text-center">
            By clicking continue, you agree to our{" "}
            <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
          </FieldDescription>
        </div>
      </div>
    </div>
  );
}

export default AuthPageLayout;
