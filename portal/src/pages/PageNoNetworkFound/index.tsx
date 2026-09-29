import image from "@/assets/images/no-network.png";

export default function PageNoNetworkFound() {
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
            Unable To Connect...
          </h1>

          <p className="text-lg leading-8 text-muted-foreground">
            We're having trouble connecting to the server. Please check your
            internet connection and ensure you have a stable network connection.
            Once connected, try again.
          </p>
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
