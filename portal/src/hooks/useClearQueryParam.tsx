import { useSearchParams } from "react-router";
import { useCallback } from "react";
import { PAGEKEY } from "./usePaginationQueryParam";
import { QueryInitialPageParam } from "@/utils/constants/query";

type CustomQueryParamHookType = () => {
  clearParamValue: () => void;
};

export const useClearQueryParam: CustomQueryParamHookType = () => {
  const [_, setSearchParams] = useSearchParams();

  const clearParamValue = useCallback(() => {
    setSearchParams(
      () => {
        const params = new URLSearchParams();
        params.set(PAGEKEY, String(QueryInitialPageParam));
        return params;
      },
      { replace: true },
    ); // 👈 prevent history spam
  }, [setSearchParams]);

  return {
    clearParamValue,
  };
};
