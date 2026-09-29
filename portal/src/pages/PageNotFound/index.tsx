import { Link } from "react-router";
import { Button } from "@/components/ui/button";

import image from "@/assets/images/page404.svg";
import { page_routes } from "@/utils/routes/page_routes";

export default function PageNotFound() {
  return (
    <div className="container mx-auto flex min-h-dvh items-center px-6">
      <div className="grid w-full items-center gap-10 md:grid-cols-2 md:gap-20">
        {/* Mobile Image */}
        <img
          src={image}
          alt="404 Illustration"
          className="mx-auto w-full max-w-md md:hidden"
        />

        {/* Content */}
        <div className="text-center md:text-left">
          <h1 className="mb-6 text-4xl font-bold tracking-tight lg:text-5xl">
            Something is not right...
          </h1>

          <p className="text-lg leading-8 text-muted-foreground">
            The page you are trying to open does not exist. You may have
            mistyped the address, or the page has been moved to another URL. If
            you think this is an error, please contact support.
          </p>

          <Link to={page_routes.dashboard.link}>
            <Button variant="outline" size="lg" className="mt-8">
              Get back to home page
            </Button>
          </Link>
        </div>

        {/* Desktop Image */}
        <img
          src={image}
          alt="404 Illustration"
          className="mx-auto hidden w-full max-w-lg md:block"
        />
      </div>
    </div>
  );
}
