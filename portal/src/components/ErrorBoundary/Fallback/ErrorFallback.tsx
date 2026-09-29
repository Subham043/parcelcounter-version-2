import type { FallbackProps } from "react-error-boundary";
import { isAxiosError } from "axios";

import { Button } from "@/components/ui/button";
import { AlertCircle, RotateCcw } from "lucide-react";

import image from "@/assets/images/error.png";

export default function ErrorFallback({
    error,
    resetErrorBoundary,
}: FallbackProps) {
    const errorMessage = () => {
        if (isAxiosError(error)) {
            return (
                error.response?.data?.message ||
                "An unexpected server error occurred."
            );
        }

        if (error instanceof Error) {
            return error.message;
        }

        return "Our app is having some issues at the moment. Please try again later.";
    };

    return (
        <main className="min-h-dvh w-full">
            <div className="container mx-auto flex min-h-dvh items-center justify-center px-4 py-8">
                <div
                    className="
            grid
            w-full
            max-w-5xl
            grid-cols-1
            items-center
            gap-10
            sm:gap-16
            md:grid-cols-2
          "
                >
                    {/* Image - mobile */}
                    <div className="flex justify-center md:hidden">
                        <img
                            src={image}
                            alt="Something went wrong"
                            className="
                h-auto
                w-full
                max-w-sm
                object-contain
              "
                        />
                    </div>

                    {/* Error content */}
                    <div className="flex flex-col items-center text-center md:items-start md:text-left">
                        <div
                            className="
                mb-5
                flex
                h-12
                w-12
                items-center
                justify-center
                rounded-full
                bg-destructive/10
              "
                        >
                            <AlertCircle className="h-6 w-6 text-destructive" />
                        </div>

                        <h1
                            className="
                text-3xl
                font-bold
                tracking-tight
                sm:text-4xl
              "
                        >
                            Something went wrong...
                        </h1>

                        <p
                            className="
                mt-4
                max-w-lg
                text-base
                leading-7
                text-muted-foreground
                sm:text-lg
              "
                        >
                            {errorMessage()}
                        </p>

                        <Button
                            variant="outline"
                            size="lg"
                            type="button"
                            onClick={resetErrorBoundary}
                            className="mt-6"
                        >
                            <RotateCcw className="mr-2 h-4 w-4" />
                            Try again
                        </Button>
                    </div>

                    {/* Image - desktop */}
                    <div className="hidden justify-center md:flex">
                        <img
                            src={image}
                            alt="Something went wrong"
                            className="
                h-auto
                w-full
                max-w-md
                object-contain
              "
                        />
                    </div>
                </div>
            </div>
        </main>
    );
}
