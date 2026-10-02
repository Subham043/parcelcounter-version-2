import { createRoot } from "react-dom/client";
import "./assets/styles/index.css";
import App from "./App.tsx";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { QueryClientOptions } from "./utils/constants/query.ts";

import { Toaster } from "./components/ui/toast.tsx";
import { TooltipProvider } from "./components/ui/tooltip.tsx";
import GlobalErrorBoundary from "./components/ErrorBoundary/GlobalErrorBoundary/index.tsx";
import { StrictMode } from "react";
import QueryErrorBoundary from "./components/ErrorBoundary/QueryErrorBoundary/index.tsx";

const queryClient = new QueryClient(QueryClientOptions);

createRoot(document.getElementById("root")!).render(
  <StrictMode>
    <GlobalErrorBoundary>
      <QueryClientProvider client={queryClient}>
        <TooltipProvider>
          <QueryErrorBoundary>
            <App />
          </QueryErrorBoundary>
        </TooltipProvider>
        <Toaster />
      </QueryClientProvider>
    </GlobalErrorBoundary>
  </StrictMode>,
);
