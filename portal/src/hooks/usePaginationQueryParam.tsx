import { useSearchParams } from "react-router";
import {
  QueryInitialPageParam,
  QueryTotalCount,
} from "@/utils/constants/query";
import { useCallback } from "react";

type PaginationQueryParamHookType = () => {
  page: number;
  total: number;
  setPage: (value: number) => void;
  setTotal: (value: number) => void;
};

export const PAGEKEY = "page";
export const TOTALKEY = "total";

export const usePaginationQueryParam: PaginationQueryParamHookType = () => {
  const [searchParams, setSearchParams] = useSearchParams();

  const page = Number(searchParams.get(PAGEKEY) || QueryInitialPageParam);
  const total = Number(searchParams.get(TOTALKEY) || QueryTotalCount);

  const setPage = useCallback(
    (value: number) => {
      setSearchParams(
        (prev) => {
          const params = new URLSearchParams(prev);
          value ? params.set(PAGEKEY, String(value)) : params.delete(PAGEKEY);
          return params;
        },
        { replace: true },
      ); // 👈 prevent history spam
    },
    [setSearchParams],
  );

  const setTotal = useCallback(
    (value: number) => {
      setSearchParams(
        (prev) => {
          const params = new URLSearchParams(prev);
          value ? params.set(TOTALKEY, String(value)) : params.delete(TOTALKEY);
          if (params.has(PAGEKEY)) {
            params.set(PAGEKEY, String(QueryInitialPageParam));
          }
          return params;
        },
        { replace: true },
      ); // 👈 prevent history spam
    },
    [setSearchParams],
  );

  return {
    page,
    total,
    setPage,
    setTotal,
  };
};
